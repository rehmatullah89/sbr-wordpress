<?php
	$contentType = "text/javascript";

	//Headers are sent to prevent browsers from caching.
	header( "Expires: Mon, 26 Jul 1997 05:00:00 GMT" );
	header( "Last-Modified: " . gmdate( "D, d M Y H:i:s" ) . "GMT" );
	header( "Cache-Control: no-store, no-cache, must-revalidate" ); // HTTP/1.1
	Header( "Cache-Control: post-check=0, pre-check=0", FALSE );
	header( "Pragma: no-cache" ); // HTTP/1.0
	header( "Content-Type: ".$contentType."; charset=utf-8" );

	//P3P POLICY FOR IE - cookies won't work without this
	@header('P3P: CP="NOI ADM DEV PSAi COM NAV OUR OTRo STP IND DEM"');

	//campaign slug
	if(@trim($_GET['campaignSlug']) == "")
	{
		$_GET['campaignSlug'] = "widget";
	}

	//bannerType = whitening/caripro
	if(@trim($_GET['bannerType']) == "")
	{
		$_GET['bannerType'] = "whitening";
	}

	//is article (set default to is not article)
	if(!(@$_GET['isArticle'] >= 0))
	{
		$_GET['isArticle'] = 0;
	}

	//set banner height & width if nothing
	if(!(@$_GET['bannerWidth'] > 0))
	{
		$_GET['bannerWidth'] = 0;
	}
	if(!(@$_GET['bannerHeight'] > 0))
	{
		$_GET['bannerHeight'] = 0;
	}

	//the link url
	$linkURL = "https://www.smilebrilliant.com#".$_GET['campaignSlug'];
	if($_GET['bannerType'] == "caripro")
	{
		$linkURL = "https://www.smilebrilliant.com/product/electric-toothbrush#".$_GET['campaignSlug'];
	}

	//set our current banner folder
	$currentBannerFolder = "general";
	if($_GET['bannerType'] == "caripro")
	{
		$currentBannerFolder = "caripro";
	}

	//grab a random image if we are using our banners
	echo "var n__bannerSource = '';";
	if($_GET['bannerWidth'] > 0 && $_GET['bannerHeight'] > 0)
	{
		$bannerArray = json_decode('{"caripro":{"773":{"228":["caripro-brush-773x228.jpg","caripro-package-773x228.jpg"]}},"general":{"120":{"600":["120x600-1.jpg"]},"160":{"600":["160x600-1.jpg","160x600-2.jpg","160x600-3.jpg"]},"200":{"200":["200x200-1.jpg","200x200-2.jpg","200x200-3.jpg","200x200-4.jpg"]},"240":{"400":["240x400-1.jpg","240x400-2.jpg","240x400-3.jpg"]},"250":{"250":["250x250-1.jpg","250x250-2.jpg","250x250-3.jpg"]},"300":{"1050":["300X1050-1.jpg","300X1050-2.jpg"],"250":["300x250-1.jpg","300x250-2.jpg","300x250-3.jpg","300x250-4.jpg"],"600":["300x600-1.jpg","300x600-2.jpg","300x600-3.jpg","300x600-4.jpg"]},"320":{"100":["320x100-1.jpg","320x100-2.jpg","320x100-3.jpg"],"50":["320x50-2.jpg"]},"336":{"280":["336x280-1.jpg","336x280-2.jpg","336x280-3.jpg","336x280-4.jpg"]},"468":{"60":["468x60-2.jpg"]},"728":{"90":["728x90-1.jpg","728x90-2.jpg"]},"850":{"250":["850x250-1.jpg","850x250-2.jpg","850x250-3.jpg"]},"970":{"250":["970x250-1.jpg","970x250-2.jpg"],"90":["970x90-1.jpg","970x90-2.jpg","970x90-3.jpg"]}}}', true);

		//pick a random banner from our folder enabled right now
		if(@count($bannerArray[$currentBannerFolder][strval($_GET['bannerWidth'])][strval($_GET['bannerHeight'])]) > 0)
		{
			$arrayRef = $bannerArray[$currentBannerFolder][strval($_GET['bannerWidth'])][strval($_GET['bannerHeight'])];
			$randomImage = $arrayRef[array_rand($arrayRef)];
			echo "n__bannerSource = 'https://www.smilebrilliant.com/static/images/widget/banners/".$currentBannerFolder."/".$randomImage."';";
		}
		//otherwise pick from our general
		else if(@count($bannerArray["general"][strval($_GET['bannerWidth'])][strval($_GET['bannerHeight'])]) > 0)
		{
			$arrayRef = $bannerArray["general"][strval($_GET['bannerWidth'])][strval($_GET['bannerHeight'])];
			$randomImage = $arrayRef[array_rand($arrayRef)];
			echo "n__bannerSource = 'https://www.smilebrilliant.com/static/images/widget/banners/general/".$randomImage."';";
		}
	}

	//basic mobile detection
	echo "var n__isMobile = false;";
	$useragent = @$_SERVER['HTTP_USER_AGENT'];
	if($useragent != "")
	{
		if(@preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$useragent)||@preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4)))
		{
			echo "n__isMobile = true;";
		}
		else
		{
			echo "n__isMobile = false;";
		}
	}

?>
	var n__bannerSource = '';n__bannerSource = 'https://www.smilebrilliant.com/static/images/widget/banners/general/850x250-2.jpg';var n__isMobile = false;n__isMobile = false;
function n__addEventListener( n__element, n__event_name, n__observer, n__capturing )
{
	if ( n__element.addEventListener )  // the DOM2, W3C way
		{  n__element.addEventListener( n__event_name, n__observer, n__capturing );  }
	else if ( n__element.attachEvent )  // the IE way
		{  n__element.attachEvent( "on" + n__event_name, n__observer );  }
}
function n__urlEncodeString(n__stringToDo)
{
	//parse what was sent as a string
	n__stringToDo = String(n__stringToDo);

	//first convert common MS characters...blah
	n__stringToDo = n__stringToDo.replace(/\u2018|\u2019|\u201e/gi, "'"). //single quote
								  replace(/\u201c|\u201d|\u201a/gi, '"'). //double quote
								  replace(/\u2026/gi, '...'). //triple dots
								  replace(/\u2022/gi, '*'). //bullet
								  replace(/\u2013/gi, '-'). //endash
								  replace(/\u2014/gi, '--'). //emdash
								  replace(/\u02dc/gi, '~'). //tilde
								  replace(/\u2122/gi, '(TM)'); //trademark

	if(window.encodeURIComponent)
	{
		n__stringToDo = encodeURIComponent(n__stringToDo); //does not encode ~!*()'
		n__stringToDo = n__stringToDo.replace(/\~/gi, "%7E").//encodeURIComponent does not handle @*/+
									  replace(/\!/gi, "%21").
									  replace(/\*/gi, "%2A").
									  replace(/\(/gi, "%28").
									  replace(/\)/gi, "%29").
									  replace(/\'/gi, "%27");
	}
	else
	{
		n__stringToDo = escape(n__stringToDo); //first url encode it
		n__stringToDo = n__stringToDo.replace(/\+/gi, "%2b").//escape does not handle @*/+
									  replace(/\//gi, "%2F").
									  replace(/\*/gi, "%2A").
									  replace(/\@/gi, "%40");
	}
	return n__stringToDo;
}

function n__getSmileBrilliantFootprintImage(n__campaignSlug)
{
	//fire sb buyer footprint request
	var n__param = '?noCache=' + (new Date()).getTime();
		n__param += "&href="+n__urlEncodeString(window.location.href);
		n__param += "&campaignSlug="+n__urlEncodeString(n__campaignSlug);
		n__param += "&referrer=";
		n__param += "&widget=1";
		n__param += "&mode=javascript";

		try
		{
			if(typeof localStorage.buyerId != 'undefined' && localStorage.buyerId != "")
			{
				n__param += "&buyerId="+n__urlEncodeString(localStorage.buyerId);
			}
		}catch(err){}

	var n__smilebrilliantFootprintImage = document.createElement('img');

	n__smilebrilliantFootprintImage.src = "//www.smilebrilliant.com/requests/request.buyerFootprint.php" + n__param;
	n__smilebrilliantFootprintImage.style.textDecoration = "none";
	n__smilebrilliantFootprintImage.style.border = "none";
	n__smilebrilliantFootprintImage.style.padding = "0px";
	n__smilebrilliantFootprintImage.style.margin = "0px";
	n__smilebrilliantFootprintImage.style.lineHeight = "0px";
	n__smilebrilliantFootprintImage.style.height = "0px";
	n__smilebrilliantFootprintImage.style.width = "0px";
	try {n__smilebrilliantFootprintImage.style.maxWidth = "none";} catch(err){}
	try {n__smilebrilliantFootprintImage.style.minWidth = "none";} catch(err){}
	try {n__smilebrilliantFootprintImage.style.maxHeight = "none";} catch(err){}
	try {n__smilebrilliantFootprintImage.style.minHeight = "none";} catch(err){}

	return n__smilebrilliantFootprintImage;
}
function n__getGoogleImage()
{
	var n__googleImage = document.createElement('img');

	n__googleImage.src = "//googleads.g.doubleclick.net/pagead/viewthroughconversion/991526735/?value=0&label=TuY6CLSk910Qz_7l2AM&guid=ON&script=0";
	n__googleImage.style.textDecoration = "none";
	n__googleImage.style.border = "none";
	n__googleImage.style.padding = "0px";
	n__googleImage.style.margin = "0px";
	n__googleImage.style.lineHeight = "0px";
	n__googleImage.style.height = "0px";
	n__googleImage.style.width = "0px";
	try {n__googleImage.style.maxWidth = "none";} catch(err){}
	try {n__googleImage.style.minWidth = "none";} catch(err){}
	try {n__googleImage.style.maxHeight = "none";} catch(err){}
	try {n__googleImage.style.minHeight = "none";} catch(err){}

	return n__googleImage;
}

function n__getFacebookImage()
{
	var n__facebookImage = document.createElement('img');

	n__facebookImage.src = "https://www.facebook.com/tr?id=872142092827065&ev=PixelInitialized";
	n__facebookImage.style.textDecoration = "none";
	n__facebookImage.style.border = "none";
	n__facebookImage.style.padding = "0px";
	n__facebookImage.style.margin = "0px";
	n__facebookImage.style.lineHeight = "0px";
	n__facebookImage.style.height = "0px";
	n__facebookImage.style.width = "0px";
	try {n__facebookImage.style.maxWidth = "none";} catch(err){}
	try {n__facebookImage.style.minWidth = "none";} catch(err){}
	try {n__facebookImage.style.maxHeight = "none";} catch(err){}
	try {n__facebookImage.style.minHeight = "none";} catch(err){}

	return n__facebookImage;
}

var n__smilebrilliantStaticWidget =
{
	n__widgetSlug : "widget",
	n__widgetMaxWidth : 850,
	n__widgetMaxHeight : 250,

	n__divWrap : null,
	n__image : document.createElement('img'),
	n__smilebrilliantFootprintImage : null,
	n__googleImage : null,
	n__facebookImage : null,

	n__init : function()
	{
		//add request
		try
		{
			var js = document.createElement('script');
				js.type = 'text/javascript';
				js.async = true;
				js.id = 'AddShoppers';
				js.src = ('https:' == document.location.protocol ? 'https://shop.pe/widget/' : 'http://cdn.shop.pe/widget/') + 'widget_async.js#5c617c03bbddbd44eae72714';
				document.getElementsByTagName("head")[0].appendChild(js);
		}catch(err){}

		try
		{
							this.n__divWrap = document.getElementById("smilebrilliant_widget");
			

			//main image
				this.n__image.src = n__bannerSource;

				//hidden image
				try
				{
					if(parseInt(this.n__mainDiv.getAttribute('ishidden')) == 1)
					{
						this.n__image.src = "";
						this.n__image.style.display = "none";
					}
				}catch(err){}

				this.n__image.style.textDecoration = "none";
				this.n__image.style.border = "none";
				this.n__image.style.padding = "0px";
				this.n__image.style.margin = "0px";
				this.n__image.style.fontSize = "0px";
				this.n__image.style.lineHeight = "0px";
				this.n__image.style.maxWidth = "none";
				try {this.n__image.style.minWidth = "none";}catch(err){}
				try {this.n__image.style.maxHeight = "none";}catch(err){}
				try {this.n__image.style.minHeight = "none";}catch(err){}
				try {this.n__image.style.width = "100%";}catch(err){}

			//main div wrap
				this.n__divWrap.style.overflow = 'hidden';
				this.n__divWrap.style.display = 'block';
				this.n__divWrap.style.cursor = 'pointer';
				this.n__divWrap.style.textDecoration = "none";
				this.n__divWrap.style.border = "none";
				this.n__divWrap.style.padding = "0px";
				this.n__divWrap.style.margin = "0px";
				this.n__divWrap.style.fontSize = "0px";
				this.n__divWrap.style.lineHeight = "0px";
				this.n__divWrap.style.width = '100%';
				this.n__divWrap.style.height = '100%';
				try {this.n__divWrap.style.maxWidth = this.n__widgetMaxWidth + 'px';}catch(err){};
				try {this.n__divWrap.style.minWidth = "none";}catch(err){};
				try {this.n__divWrap.style.maxHeight = this.n__widgetMaxHeight + 'px';}catch(err){};
				try {this.n__divWrap.style.minHeight = "none";}catch(err){};
				this.n__divWrap.target = "_blank";

				//if tag name
				if(this.n__divWrap.tagName == "A" || this.n__divWrap.tagName == "a")
				{
					this.n__divWrap.href = "https://www.smilebrilliant.com#widget";
				}
				else
				{
					this.n__divWrap.onclick = function()
					{
						window.location.href = "https://www.smilebrilliant.com#widget";
						return false;
					}
				}
				this.n__divWrap.appendChild(this.n__image);

			//hiding image
			try
			{
				if(parseInt(this.n__divWrap.getAttribute('ishidden')) == 1)
				{
					this.n__image.style.display = 'none';

					try {this.n__divWrap.style.maxWidth = "1px";}catch(err){};
					try {this.n__divWrap.style.minWidth = "1px";}catch(err){};
					try {this.n__divWrap.style.maxHeight = "1px";}catch(err){};
					try {this.n__divWrap.style.minHeight = "1px";}catch(err){};
					this.n__divWrap.style.height = '1px';
					this.n__divWrap.style.width = '1px';
					this.n__divWrap.style.visibility = 'hidden';
				}
			}catch(err){}


			//google image
				this.n__googleImage = n__getGoogleImage();
				this.n__divWrap.appendChild(this.n__googleImage);

			//facebook image
				//this.n__facebookImage = n__getFacebookImage();
				//this.n__divWrap.appendChild(this.n__facebookImage);

			//sb buyer footprint image
				this.n__smilebrilliantFootprintImage = n__getSmileBrilliantFootprintImage(this.n__widgetSlug);
				this.n__divWrap.appendChild(this.n__smilebrilliantFootprintImage);


		}catch(err){};
	}
};

n__smilebrilliantStaticWidget.n__init();
