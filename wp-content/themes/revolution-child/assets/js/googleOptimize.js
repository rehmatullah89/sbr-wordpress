window.dataLayer = window.dataLayer || [];

if (typeof gtag == 'undefined') {
    function gtag() {
        dataLayer.push(arguments);
    }
}

class Deferred {
    constructor() {
        this.resolved = false;
        this.promise = new Promise(resolve => {
            this.resolve = value => {
                this.resolved = true;
                resolve(value);
            };
        });
    }
}

class GoogleOptimizeManager {
    constructor(timeoutMs) {
        this.activated = {};
        this.experiments = {};
        this.useDefaults = false;

        // Only wait a short while for experiment values to get set.
        // If they aren't set in our timeout window, return default null values.
        setTimeout(() => {
            this.useDefaults = true;

            for (let experimentId in this.experiments) {
                let experiment = this.experiments[experimentId];
                if (experiment.resolved) {
                    continue;
                }

                experiment.resolve(null);
            }
        }, timeoutMs);
    }

    activateExperiment(experimentId) {
        let experiment = null;

        if (typeof window.GoogleOptimizeError != 'undefined' && window.GoogleOptimizeError) {
            // This flag is set if the Google Optimize library fails to load for some reason (e.g. adblock).
            // In this case, we resolve the experiment immediately.
            experiment = this._set(experimentId, null);
        } else if (!this.activated[experimentId]) {
            // Activate experiment using activation naming convention.
            this.activated[experimentId] = true;
            dataLayer.push({ event: `optimize.activate.${experimentId}` });

            if (typeof google_optimize != 'undefined') {
                // Google Optimize API is available, so we
                // resolve the experiment value immediately.
                let value = google_optimize.get(experimentId);
                experiment = this._set(experimentId, value);
            } else {
                // Experiment value is not immediately available.
                // Register for experiment value callback.
                gtag('event', 'optimize.callback', {
                    name: experimentId,
                    callback: (value, experimentId) => this._set(experimentId, value)
                });
            }
        }

        if (!experiment) {
            experiment = this._experiment(experimentId);
        }

        // If experiment value hasn't resolved yet and we've
        // surpassed our timeout, return a default null value.
        if (!experiment.resolved && this.useDefaults) {
            experiment.resolve(null);
        }

        return experiment.promise;
    }

    isExperimentActive(experimentId) {
        // Experiment is active only if local storage value exists and is non-null.
        return this.getExperimentVariant(experimentId) !== null;
    }

    async getExperimentVariant(experimentId) {
   
     //   let variant = store.get(`formulate:experiment:${experimentId}`);
        let variant =  localStorage.getItem(`sbr:experiment:${experimentId}`);
        return variant || null;
    }

    _set(experimentId, value) {
        if (value === undefined) {
            value = null;
        }

        // For MVTs, split values into an array.
        if (value != null && value.indexOf('-') >= 0) {
            value = value.split('-');
        }

        let experiment = this._experiment(experimentId);
        experiment.resolve(value);
        return experiment;
    }

    _experiment(experimentId) {
        // Return cached or newly created experiment.
        let experiment = this.experiments[experimentId];
        if (experiment) {
            return experiment;
        }

        experiment = this.experiments[experimentId] = new Deferred();
       
        // Store resolved experiment value (even if null) in local storage.
        experiment.promise.then(value => {
            localStorage.setItem(`sbr:experiment:${experimentId}`, value);
          //  store.set(`formulate:experiment:${experimentId}`, value);
        });

        // Add experiment values as attributes to the DOM so we can
        // style based on experiment value selectors.
        experiment.promise.then(value => {
            if (value == null) {
                return;
            }

            var values;
            if (typeof value == 'object') {
                values = value;
            } else {
                values = [value];
            }

            for (let i = 0; i < values.length; i++) {
                let name = `experiment-${experimentId}-${i}`;
                document.body.setAttribute(name, values[i]);
            }
        });

        return experiment;
    }
}

// Use zero timeout when not enabled to force immediate use of default values.
const GoogleOptimize = new GoogleOptimizeManager(0);

//export default GoogleOptimize;

function loadSBR_Optimize() {
    GoogleOptimize.activateExperiment('WTsim3f_RhqXQD2U33yUzg');
}
document.addEventListener('DOMContentLoaded', loadSBR_Optimize);