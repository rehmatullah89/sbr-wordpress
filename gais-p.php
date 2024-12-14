<?php
set_time_limit(0);
ini_set('memory_limit', '1024M');
require '/home/nginx/domains/smilebrilliant.com/public/gais/vendor/autoload.php';
require_once('/home/nginx/domains/smilebrilliant.com/public/wp-load.php');

use phpseclib3\Net\SFTP;

class GAISCRON{

    // SFTP server details
    public $sftpHost = 'ftp.coverdell.com';
    public $sftpPort = 22; // default SFTP port
    public $sftpUsername = 'Smile.ftp';
    public $sftpPassword = 'EndWinter2024';
    public $fileStatus = 0;
    public $email = "rehmatullah@mindblazetech.com"; 
    // public $sftpHost = '192.168.0.165';
    // public $sftpPort = 22; // default SFTP port
    // public $sftpUsername = 'root';
    // public $sftpPassword = "xlma2190";

    public $connection;
    public $outputfile;
    public $outputfilefinal;
    public $publicKey = <<<EOT
-----BEGIN PGP PUBLIC KEY BLOCK-----
Version: PGP Desktop 9.0.5 (Build 5050) - not licensed for commercial use: www.pgp.com

mQENBEnx7kUBCACaTPpU0PwkQ3MrFex0a9/ubt3I8JI/aJn9Shdn2yCi2iOppZ/I
uS4zTiqSlpRHxswlMqQGdn+P6fb2DimbD/3R2s9jXSqpAUugog7moN55nqlyRr7H
xJ2GNv9RbOgx2WrYt3O9g444jbCi01TZ1TyAk3bGwZJvlfn+x182r8kDs9IUqP9F
8vlUhUR4qcFn51frjPXJ8F3cVyJVGau+qg/nz+2muwjMw+o+wUJlPVDE42wL4vDo
YxSvZNEM5ha4wlUbHBcfdAi0o1E7l+St4PF+r8XByAQ9tYzBBx7ebcj3ldbudyTH
1R3tSF4ZKkZn+4CFN5HLJk15KyCUCkgFTeVFABEBAAG0IUNvdmVyZGVsbCBEUCA8
ZGF0YUBjb3ZlcmRlbGwuY29tPokBbQQQAQIAVwUCSfHuRTAUgAAAAAAgAAdwcmVm
ZXJyZWQtZW1haWwtZW5jb2RpbmdAcGdwLmNvbXBncG1pbWUHCwkIBwMCCgIZAQUb
AwAAAAMWAgEFHgEAAAAEFQgJCgAKCRCtSWdvp8iRMF/7CACFOQqeJ5kahUEGBgw6
awrXFSeT69UMoPxX3o7E/VWzF+irWqnrnIk/GSZLjugmOWTMXBjbikYSG1YloIGg
dYxz8BGTmQ+6psU7Jm928XH0LNDKaXIvvlVss3G90etKn0lugbBWhcIxlXCU3W0w
C3egfXF5CdeLuDshRgokw1WhAznPPQiTJiTu8DVOtXK+NLdEIP8qClHPpzGu02X7
7TiFR/vzZOC3Ifzl0fu3aRhaZ/lsObvRdRv5WrKyFmJ9SnJ9UtYkyoUlXxrcwahZ
rp8JbBGuND8x6//JrsQKaE+N/ejh8PMmfiGcj2PQHL4Y4Tt3MVHVfK3Y08P/hy1v
1EJpuQENBEnx7kYBCADMhk9Op8Gp+7PNQxamlcmpPy+GTTNiLFX1VQ5UvG/vIePh
As0sW3lbNzLM+YBSZPOI1b9XQK5VKslbPmCEGRYT2Zpyu6+s5xHdlvTmjdQkXFwt
tGS/x8xBqfJW/y4H4Pum1CiI4Ea9fv4KdJozFYlrvomFXddHuSzKol5tcvbU52SN
EYqsm7pUmJ5dixfWP1U5n7Px1k4NB//TlSdSjV/CJYMdppzbAzv3mKToM7mLHZii
e1lTnQLX3oZokjWnOiRk9ejshIHDRb7p4Q9AmFGtygUznYXntE0kJVVEoJAPFWkw
o2PIX668hxLhK9VuGU0kfEdbPoryVQb5nXgdmawBABEBAAGJASIEGAECAAwFAknx
7kYFGwwAAAAACgkQrUlnb6fIkTC0ngf/c7WKqdgDRxqZYtc0+fUVvwavxWg4wL/c
LLwhJ/q+dDtw4SFt/iqhOz8/4szZpqcfigqBOe64JAHU2+Z9FK6jRocBjmcSHkKn
PRhZ0B9+7rWr0wXpqR31tSBbb9IhIbnH3T9xzFrVG31kofIwxWZ1zzIz0SwJFumu
BHNWVnpR9x/o5vaVoIugI9lERhdxDlziMl53fWtKcs//vCb50CpUQ/Gl2oVK8sAk
sWazgGbmw2j0nGTSMdQEnSdehtniakjXhTA2xouSxJNfItrudbfAKR2kt9IOUbEz
XfWjpqlJ1cWRn9pq9ifj9JFEj396+2OMOcuPUIj8xI77YxK6cs2juQ==
=CYOp
-----END PGP PUBLIC KEY BLOCK-----
EOT;

    const EXPORT_DIR = '/home/nginx/domains/smilebrilliant.com/public/gais/exports/';
    const TEXT_FILE = '/home/nginx/domains/smilebrilliant.com/public/gais/GAIS-LOGS.txt';
    const PUBLIC_KEY = "948FB3D87A786B97623D7485AD49676FA7C89130";
    
    function __construct(){
        global $wpdb;
        $this->connection = $wpdb;
        
        //generate new csv file with format
        $currentDate = new DateTime();
        $formattedDate = $currentDate->format('Ymd');
        $this->outputfile = self::EXPORT_DIR."0UNP{$formattedDate}test.csv";
        $this->outputfilefinal = self::EXPORT_DIR."0UNP{$formattedDate}test.csv.pgp";
        
        //remove existing files
        $this->removeExistingFiles();

        //generate files
        $this->writeCsvFile();
        $this->encryptFile();
        $this->uploadFileToSFtp();

    }

    public function writeLogsOnTextFile($data){
        $file = fopen(self::TEXT_FILE, "w");

        if (!$file) {
            $this->writeLogsOnTextFile("Failed to open file: ".self::TEXT_FILE);
            $this->sendNotification($this->email, "Failed to open file: ".self::TEXT_FILE);
            return; // Stop further execution if the file cannot be opened
        }

        fwrite($file, "\n" . date('Y-m-d h:i:s') . " :: " . $data);
        fclose($file);

        $this->update_db_logs($data);
    }

    public function update_db_logs($data)
    {
        // get & log current date logs
        $current_content = $this->connection->get_row(
            $this->connection->prepare(
                "SELECT id,logs FROM gais_logs WHERE DATE(created_at) = %s",
                date('Y-m-d')
            )
        );
        // Concatenate the new content with the existing content
        if ($current_content) {
            // Record exists, update the log content
            $updated_content = $current_content->logs . "\n" . $data; 
            $this->connection->update(
                'gais_logs',
                array('logs' => $updated_content),
                array('id' => $current_content->id)
            );
        } else {
            // Record doesn't exist, insert a new one
            $this->connection->insert(
                'gais_logs',
                array(
                    'logs' => $data,
                    'created_at' => date('Y-m-d H:i:s')
                ),
                array('%s','%s')
            );
        }
    }

    public function encryptFile(){
        try {
            // Encrypt Function
            $pgp = new gnupg();
            $keyInfo = $pgp->keyinfo(self::PUBLIC_KEY);
            if (empty($keyInfo)) {
                $pgp->import($this->publicKey);
                //***^*****\\ 
               //***^||^****\\ print first time public key to get
              //....___......\\
             //...--^--^.......\\
            }
           
            $csvFiles = glob(self::EXPORT_DIR.'*.csv');
            if ($csvFiles) {
                // Sort the files by modification time, descending
                usort($csvFiles, function($a, $b) {
                    return filemtime($b) - filemtime($a);
                });
        
                // Get the latest CSV file & Key
                $latestFile = $csvFiles[0];
                $csvContent = file_get_contents($latestFile);                
                $pgp->addencryptkey(self::PUBLIC_KEY);
                $encryptedData =  $pgp->encrypt($csvContent);
    
                // Write the encrypted content to the output file
                file_put_contents($this->outputfilefinal, $encryptedData);

                //decrypt file 
                // $pgp->adddecryptkey(self::PRIVATE_KEY, '');
                // $pgpContent = file_get_contents($this->outputfilefinal);                
                // $pgpContent = $pgp->decrypt($pgpContent);
                // print_r($pgpContent);exit;

                $this->writeLogsOnTextFile("File encrypted successfully and saved as $this->outputfilefinal");    
            }
        } catch (Exception $e) {
            $this->writeLogsOnTextFile('An error occurred during encrypt: ' . $e->getMessage());   
            $this->sendNotification($this->email, 'An error occurred during encrypt: ' . $e->getMessage());
        }
    }

public function uploadFileToSFtp()
{
    $pgpFiles = glob(self::EXPORT_DIR . '*.pgp');
    if ($pgpFiles && $this->fileStatus == 1) {
        // Sort the files by modification time, descending
        usort($pgpFiles, function ($a, $b) {
            return filemtime($b) - filemtime($a);
        });

        // Get the latest CSV file & Key
        $latestFile = $pgpFiles[0];

        try {
            // Create an SFTP instance
            $sftp = new SFTP($this->sftpHost, $this->sftpPort);

            // Connect to the SFTP server && Exit the function if login fails
            if (!$sftp->login($this->sftpUsername, $this->sftpPassword)) {
                $this->writeLogsOnTextFile('Login failed to the SFTP server.');
                $this->sendNotification($this->email, 'Login failed to the SFTP server.');
                return;
            }

            // Check connection status
            if (!$sftp->isConnected()) {
                $this->writeLogsOnTextFile('Failed to connect to the SFTP server.');
                $this->sendNotification($this->email, 'Failed to connect to the SFTP server.');
                return; // Exit the function if connection fails
            }

             // Get the current directory path
             $currentDir = $sftp->pwd();
             $this->writeLogsOnTextFile("Current SFTP directory: $currentDir");
            

            // Upload the file
            if (!$sftp->put("/" . basename($latestFile), $latestFile, SFTP::SOURCE_LOCAL_FILE)) {
                $this->writeLogsOnTextFile("Failed to upload the file: $latestFile");
                $this->sendNotification($this->email, "Failed to upload the file: $latestFile");
            } else {
                $this->writeLogsOnTextFile("File uploaded successfully to /");
            }
        } catch (Exception $e) {
            $this->writeLogsOnTextFile('An error occurred during upload: ' . $e->getMessage());
            $this->sendNotification($this->email, 'An error occurred during upload: ' . $e->getMessage());
        } catch (Error $e) {
            $this->writeLogsOnTextFile('A system error occurred during upload: ' . $e->getMessage());
            $this->sendNotification($this->email, 'A system error occurred during upload: ' . $e->getMessage());
        }
    } else {
        $this->writeLogsOnTextFile('No PGP files found to upload.');
        $this->sendNotification($this->email, 'No PGP files found to upload.');
    }
}

    public function removeExistingFiles(){
        $csvFiles = glob(self::EXPORT_DIR.'*.csv*');
        try{
            if ($csvFiles) {
                // Loop through the CSV files and delete each one
                foreach ($csvFiles as $filePath) {
                    if (unlink($filePath)) {
                        $this->writeLogsOnTextFile("File deleted successfully: $filePath\n");
                    } else {
                        $this->writeLogsOnTextFile("File could not be deleted: $filePath");     
                    }
                }
            } else {
                $this->writeLogsOnTextFile("No CSV files found in the directory: ".self::EXPORT_DIR);
                $this->sendNotification($this->email, "No CSV files found in the directory: ".self::EXPORT_DIR);     
            }
        }catch(Exception $e){
            $this->writeLogsOnTextFile("File could not be deleted: ".$e);     
        }
    }

    public function writeCsvFile() {
        try {
            // Open the output CSV file
            $file = fopen($this->outputfile, 'w');
        
            // Write the CSV header
            /*$header = [
                'Group Number',
                'Unique ID Number',
                'Last Name',
                'First Name',
                'Address Line 1',
                'Address Line 2',
                'City',
                'State Of Province',
                'Postal Code',
                'Country Code',
                'Phone',
                'Expiration Date',
                'Effective Date',
                'Sponsor/ Agent ID',
                'Optional Data 1',
                'Optional Data 2',
                'Optional Data 3',
                'No Market',
                'Enrollment Code',
                'Date of Birth',
                'Gender Code',
                'Email Address'
            ];*/

            $columns = ['group_number','unique_id_no','last_name','first_name','address1','address2','city','state','postal_code','country_code','phone','expiration_date','effective_date','agent_id','optional_data1','optional_data2','optional_data3','no_market','enrollment_code','dob','gender','email','gais_report_type'];

            $header = [
                'BBHDR200',
                '0UN',
                'P',
                date('Ymd'),
                'Y',
                $this->email
            ];

            if (!$this->custom_fputcsv($file, $header)) {
                $this->writeLogsOnTextFile("Unable to write header to CSV file: $this->outputfile");
                $this->sendNotification($this->email, "Unable to write header to CSV file: $this->outputfile");
            }
        
            $subscriptions = $this->connection->get_results("SELECT * FROM sbr_subscription_details WHERE (STATUS = 1 OR next_order_date >= NOW()) AND shine_group_code != 0 GROUP BY user_id, product_id");                                    

            foreach ($subscriptions as $subscription) {
                $customer = new WC_Customer($subscription->user_id);        
                $row = [
                    $subscription->shine_group_code?:'577200',
                    sprintf('%06s', $subscription->user_id),
                    $customer->get_billing_last_name(),
                    $customer->get_billing_first_name(),
                    $customer->get_billing_address_1(),
                    $customer->get_billing_address_2(),
                    $customer->get_billing_city(),
                    $customer->get_billing_state(),
                    $customer->get_billing_postcode(),
                    $customer->get_billing_country(),                    
                    $this->processPhoneNumber($customer->get_billing_phone()),
                    '',//$subscription->next_order_date
                    '',//$subscription->subscription_date
                    '',//$subscription->user_id
                    '',
                    '',
                    '',
                    '',
                    '',//$subscription->subscription_id
                    '',
                    '',
                    $customer->get_billing_email(),
                ];
        
                if (!$this->custom_fputcsv($file, $row)) {
                    $this->fileStatus = 1;
                    $this->writeLogsOnTextFile("Unable to write data to CSV file: $this->outputfile");
                    $this->sendNotification($this->email, "Unable to write data to CSV file: $this->outputfile");     
                }

                if(!empty($row))
                {
                    array_push($row, 'P');
                    $insert_data = array_combine($columns, $row);
                    $inserted = $this->connection->insert(
                        'gais_uploads',
                        $insert_data
                    );

                    if ($inserted === false) {
                        // Log or display the error message
                        $error_message = $this->connection->last_query;
                        error_log('Error inserting data: ' . $error_message);
                        echo 'Failed to insert data: ' . esc_html($error_message);
                        $this->writeLogsOnTextFile("'Failed to insert data: ' . esc_html($error_message)");
                    } else {
                        $this->writeLogsOnTextFile("Data inserted successfully.");
                    }
                }
                
            }
            // Close the file
            fclose($file);
            $this->writeLogsOnTextFile("CSV file generated successfully at $this->outputfile");            
        } catch (Exception $e) {
            $this->writeLogsOnTextFile('An error occurred while writing csv: ' . $e->getMessage());
            $this->sendNotification($this->email, 'An error occurred while writing csv: ' . $e->getMessage());                 
        }
    }

    function processPhoneNumber($phoneNumber) {
        // Step 1: Remove all non-digit characters
        $cleanedPhone = preg_replace('/\D/', '', $phoneNumber);

        // Step 2: Remove leading zero if present
        if (substr($cleanedPhone, 0, 1) == '0') {
            $cleanedPhone = substr($cleanedPhone, 1);
        }
        
        // Step 3: Trim to 10 digits if longer
        if (strlen($cleanedPhone) > 10) {
            $cleanedPhone = substr($cleanedPhone, 0, 10);
        }
        
        return $cleanedPhone;
    }
    
    //Custom function to handle double-quoting non-empty values
    function custom_fputcsv($file, $data, $delimiter = ',', $enclosure = '"', $escape_char = '\\') {
        try{           
            // Ensure each value is properly enclosed in double quotes if it is not empty
            $quotedData = array_map(function($field) use ($enclosure) {
                if ($field === '' || $field === null) {
                    return $field;
                }
                return $enclosure . str_replace($enclosure, $enclosure . $enclosure, $field) . $enclosure;
            }, $data);
            
            // Join the quoted data with the delimiter
            $line = implode($delimiter, $quotedData) . "\n";

            // Write the line to the file
            fwrite($file, $line);
        }
        catch(Exception $e){
           $this->writeLogsOnTextFile('An error occurred while writing csv: ' . $e->getMessage());                            
        }
    }

    public function sendNotification($to, $message)
    {
        $subject = 'GAIS Cron Notification';
        $headers = array('Content-Type: text/html; charset=UTF-8');
        $attachments = array(); // You can add file paths here if you want to send attachments
        if (wp_mail($to, $subject, $message, $headers, $attachments)) {
            $this->writeLogsOnTextFile('Email sent successfully.');
        } else {
            $this->writeLogsOnTextFile('Email sending failed.');
        }
    }
}

$cron = new GAISCRON();
header("HTTP/1.1 200 OK");

?>