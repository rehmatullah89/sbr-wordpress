<?php
		
		$contentType = "text/javascript";
		// if (rand(0, 1)) {
		// 	$free_shipping = 'yes';
		// 	$rand_text = "$37.45 + free shipping vs $119.00";
		// 	$price_only = "$37.45";
		// 	$shippingText = "<div style='font-size:0.6em;font-weight:normal;'>Free Shipping</div>";

		// }
		// else{
		// 	$free_shipping = 'no';
		// 	$rand_text = "$29.95  + $7.50 s&h vs $119.00";
		// 	$price_only = "$29.95";
		// 	$shippingText = "";
		// }
		$free_shipping = 'yes';
			$rand_text = "$37.45 + free shipping vs $119.00";
			$price_only = "$37.45";
			$shippingText = "<div style='font-size:0.6em;font-weight:normal;'>Free Shipping</div>";

		//Headers are sent to prevent browsers from caching.
		header( "Expires: Mon, 26 Jul 1997 05:00:00 GMT" );
		header( "Last-Modified: " . gmdate( "D, d M Y H:i:s" ) . "GMT" );
		header( "Cache-Control: no-store, no-cache, must-revalidate" ); // HTTP/1.1
		Header( "Cache-Control: post-check=0, pre-check=0", FALSE );
		header( "Pragma: no-cache" ); // HTTP/1.0
		header( "Content-Type: ".$contentType."; charset=utf-8" );

//echo '<pre style="word-wrap: break-word; white-space: pre-wrap;">';

		@header('P3P: CP="NOI ADM DEV PSAi COM NAV OUR OTRo STP IND DEM"');

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
var n__isMobile = false;n__isMobile = false;function n__checkEmail(n__emailValue)
{
	var n__emailMatch = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return n__emailMatch.test(n__emailValue);
}

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

//gets the current browser height and width
function n__getWindowState()
{
	var n__windowDimensions = new Array();

	n__windowDimensions[0] = n__windowWidth();
	n__windowDimensions[1] = n__windowHeight();

	function n__windowWidth()
	{
		if(typeof window.innerWidth != 'undefined' && window.innerWidth > 0)
		{
			return window.innerWidth;
		}
		else if(typeof document.documentElement.clientWidth != 'undefined' && document.documentElement.clientWidth  > 0)
		{
			return document.documentElement.clientWidth;
		}
		else if(typeof document.body.clientWidth != 'undefined' && document.body.clientWidth  > 0)
		{
			return document.documentElement.clientWidth;
		}
	}
	function n__windowHeight()
	{
		if(typeof window.innerHeight != 'undefined' && window.innerHeight > 0)
		{
			return window.innerHeight;
		}
		else if(typeof document.documentElement.clientHeight != 'undefined' && document.documentElement.clientHeight  > 0)
		{
			return document.documentElement.clientHeight;
		}
		else if(typeof document.body.clientHeight != 'undefined' && document.body.clientHeight  > 0)
		{
			return document.documentElement.clientHeight;
		}
	}
	return n__windowDimensions;
}

var n__smilebrilliantGehaWidgets =
{
	//pixels
	n__pixelRequster : document.createElement('img'),

	//MAIN WIDGET
	n__mainDivWrap : null,
	n__mainTopBanner : document.createElement('div'),
	n__mainTopBannerOrange : document.createElement('div'),
	n__mainImage : document.createElement('img'),
	n__mainPrimaryContent : document.createElement('div'),
	n__mainHRDiv : document.createElement('div'),
	n__mainIncludedTitleDiv : document.createElement('div'),
	n__mainIncludedContentDiv : document.createElement('div'),
	n__mainClaimBrushButton : document.createElement('button'),

	//SIDEBAR WIDGET
	n__sidebarDivWrap : null,
	n__sidebarTopBanner : document.createElement('div'),
	n__sidebarTopBannerBlue : document.createElement('div'),
	n__sidebarImage : document.createElement('img'),
	n__sidebarPrimaryContent : document.createElement('div'),
	n__sidebarLimitedContentDiv : document.createElement('div'),
	n__sidebarButton : document.createElement('button'),

	//HEADER BAR
	n__headerBarWrap : document.createElement('div'),
	n__headerBarCentered : document.createElement('div'),
	n__headerBarText : document.createElement('div'),
	n__headerBarButton : document.createElement('div'),

	//LIGHTBOX BACKGROUND
	n__lightboxMask : document.createElement('div'),

	//LIGHTBOX WIDGET
	n__lightboxDivWrap : document.createElement('div'),
	n__lightboxCloseDiv : document.createElement('div'),
	n__lightboxTopBanner : document.createElement('div'),
	n__lightboxTopBannerOrange : document.createElement('div'),
	n__lightboxImage : document.createElement('img'),
	n__lightboxHRDiv : document.createElement('div'),

	n__lightboxIncludedTitleDiv : document.createElement('div'),
	n__lightboxIncludedContentDiv : document.createElement('div'),

	n__lightboxStep1TitleDiv : document.createElement('div'),
	n__lightboxStep1ContentDiv : document.createElement('div'),

	n__lightboxStep1FormTitleDiv : document.createElement('div'),
	n__lightboxStep1FormLabelDiv : document.createElement('div'),
	n__lightboxStep1FormInput : document.createElement('input'),

	n__lightboxStep2FormWrapDiv : document.createElement('div'),
	n__lightboxStep2PriceEachDiv : document.createElement('div'),
	n__lightboxStep2FormClear : document.createElement('div'),

	n__lightboxStep2ErrorDiv : document.createElement('div'),
	n__lightboxStep2QuantityDiv : document.createElement('div'),
	n__lightboxStep2QuantityLabelDiv : document.createElement('div'),
		n__lightboxStep2InputMinus : document.createElement('button'),
		n__lightboxStep2InputPlus : document.createElement('button'),
		n__lightboxStep2Input : document.createElement('input'),

	n__lightboxGetDiscountButton : document.createElement('button'),


	n__init : function()
	{
		//include the widget style sheet
		var n__styleInclude = document.createElement('link');
		n__styleInclude.type = 'text/css';
		n__styleInclude.rel = 'stylesheet';
		n__styleInclude.href = 'https://www.smilebrilliant.com/static/style/geha-widget.css';
		document.head.appendChild(n__styleInclude);


		//MAIN WIDGET
		try
		{
			this.n__mainDivWrap = document.getElementById("smilebrilliant_geha_widget_main");

			//main div wrap
				this.n__mainDivWrap.style.overflow = 'hidden';
				this.n__mainDivWrap.style.display = 'block';
				this.n__mainDivWrap.style.textDecoration = "none";
				this.n__mainDivWrap.style.border = "none";
				this.n__mainDivWrap.style.padding = "0px";
				this.n__mainDivWrap.style.margin = "0px";
				this.n__mainDivWrap.style.fontSize = "0px";
				this.n__mainDivWrap.style.lineHeight = "0px";
				this.n__mainDivWrap.style.width = '100%';
				this.n__mainDivWrap.style.height = '100%';
				this.n__mainDivWrap.style.border = 'solid #3c98cc 2px';
				this.n__mainDivWrap.style.maxWidth = '600px';
				this.n__mainDivWrap.style.maxHeight = 'none';
				this.n__mainDivWrap.style.minWidth = 'none';
				this.n__mainDivWrap.style.minHeight = '900px';
				

			//top blue banner
				this.n__mainTopBanner.innerHTML = "ELECTRIC TOOTHBRUSH";
				this.n__mainTopBanner.style.textAlign = "center";
				this.n__mainTopBanner.style.paddingTop = "15px";
				this.n__mainTopBanner.style.paddingBottom = "15px";
				this.n__mainTopBanner.style.fontFamily = "Montserrat, sans-serif";
				this.n__mainTopBanner.style.fontSize = "32px";
				this.n__mainTopBanner.style.lineHeight = "32px";
				this.n__mainTopBanner.style.fontWeight = "bold";
				this.n__mainTopBanner.style.color = "white";
				this.n__mainTopBanner.style.backgroundColor = "#3c98cc";
				this.n__mainDivWrap.appendChild(this.n__mainTopBanner);

			//top orange banner
				this.n__mainTopBannerOrange.innerHTML = "MEMBER EXCLUSIVE DISCOUNT";
				this.n__mainTopBannerOrange.style.textAlign = "center";
				this.n__mainTopBannerOrange.style.paddingTop = "10px";
				this.n__mainTopBannerOrange.style.paddingBottom = "10px";
				this.n__mainTopBannerOrange.style.fontFamily = "Open Sans, Geneva, Helvetica, Arial, Tahoma, Verdana, sans-serif";
				this.n__mainTopBannerOrange.style.fontSize = "16px";
				this.n__mainTopBannerOrange.style.letterSpacing = "1px";
				this.n__mainTopBannerOrange.style.lineHeight = "16px";
				this.n__mainTopBannerOrange.style.fontWeight = "bold";
				this.n__mainTopBannerOrange.style.color = "white";
				this.n__mainTopBannerOrange.style.backgroundColor = "#ffa489";
				this.n__mainDivWrap.appendChild(this.n__mainTopBannerOrange);

			//main image
				this.n__mainImage.src = "https://www.smilebrilliant.com/static/images/product/geha-caripro-offer.jpg";
				this.n__mainImage.style.textDecoration = "none";
				this.n__mainImage.style.border = "none";
				this.n__mainImage.style.padding = "0px";
				this.n__mainImage.style.margin = "0px";
				this.n__mainImage.style.marginTop = "10px";
				this.n__mainImage.style.fontSize = "0px";
				this.n__mainImage.style.lineHeight = "0px";
				this.n__mainImage.style.maxWidth = "none";
				this.n__mainImage.style.minWidth = "none";
				this.n__mainImage.style.maxHeight = "none";
				this.n__mainImage.style.minHeight = "none";
				this.n__mainImage.style.width = "100%";
				this.n__mainDivWrap.appendChild(this.n__mainImage);

			//primary content
				this.n__mainPrimaryContent.innerHTML = "Ready to start using an electric toothbrush? Your GEHA membership gets you 70% OFF premium electric toothbrushes by cariPRO (<?php echo $rand_text;?>). This is an exclusive offer and must be redeemed while supplies are available.";
				this.n__mainPrimaryContent.style.fontSize = '16px';
				this.n__mainPrimaryContent.style.lineHeight = '21px';
				this.n__mainPrimaryContent.style.textAlign = "center";
				this.n__mainPrimaryContent.style.paddingTop = "10px";
				this.n__mainPrimaryContent.style.paddingBottom = "20px";
				this.n__mainPrimaryContent.style.paddingLeft = "20px";
				this.n__mainPrimaryContent.style.paddingRight = "20px";
				this.n__mainPrimaryContent.style.fontFamily = "Open Sans, Geneva, Helvetica, Arial, Tahoma, Verdana, sans-serif";
				this.n__mainPrimaryContent.style.color = '#555759';
				this.n__mainDivWrap.appendChild(this.n__mainPrimaryContent);

			//hr div
				this.n__mainHRDiv.innerHTML = "";
				this.n__mainHRDiv.style.fontSize = '0px';
				this.n__mainHRDiv.style.lineHeight = '0px';
				this.n__mainHRDiv.style.backgroundColor = '#c5c6c9';
				this.n__mainHRDiv.style.height = '1px';
				this.n__mainHRDiv.style.marginLeft = '40px';
				this.n__mainHRDiv.style.marginRight = '40px';
				this.n__mainDivWrap.appendChild(this.n__mainHRDiv);

			//included with title div
				this.n__mainIncludedTitleDiv.innerHTML = "INCLUDED WITH EACH KIT";
				this.n__mainIncludedTitleDiv.style.fontSize = '18px';
				this.n__mainIncludedTitleDiv.style.lineHeight = '21px';
				this.n__mainIncludedTitleDiv.style.textAlign = "center";
				this.n__mainIncludedTitleDiv.style.paddingTop = "20px";
				this.n__mainIncludedTitleDiv.style.paddingBottom = "20px";
				this.n__mainIncludedTitleDiv.style.paddingLeft = "10px";
				this.n__mainIncludedTitleDiv.style.paddingRight = "10px";
				this.n__mainIncludedTitleDiv.style.fontFamily = "Open Sans, Geneva, Helvetica, Arial, Tahoma, Verdana, sans-serif";
				this.n__mainIncludedTitleDiv.style.fontWeight = "bold";
				this.n__mainIncludedTitleDiv.style.color = '#555759';
				this.n__mainDivWrap.appendChild(this.n__mainIncludedTitleDiv);

			//included with content div
				this.n__mainIncludedContentDiv.innerHTML = "<ul><li>x1 cariPRO Electric  Toothbrush</li> <li>x1 Wireless charging doc</li><li> x2 replacement brush heads w/tongue scraper & DuPont Bristles</li><li> 2 Year limited warranty</ul>";
				this.n__mainIncludedContentDiv.style.fontSize = '16px';
				this.n__mainIncludedContentDiv.style.lineHeight = '22px';
				this.n__mainIncludedContentDiv.style.textAlign = "center";
				this.n__mainIncludedContentDiv.style.paddingTop = "20px";
				this.n__mainIncludedContentDiv.style.paddingBottom = "20px";
				this.n__mainIncludedContentDiv.style.paddingLeft = "10px";
				this.n__mainIncludedContentDiv.style.paddingRight = "10px";
				this.n__mainIncludedContentDiv.style.fontFamily = "Open Sans, Geneva, Helvetica, Arial, Tahoma, Verdana, sans-serif";
				this.n__mainIncludedContentDiv.style.fontWeight = "normal";
				this.n__mainIncludedContentDiv.style.color = '#555759';
				this.n__mainDivWrap.appendChild(this.n__mainIncludedContentDiv);


			//claim brush button
				this.n__mainClaimBrushButton.innerHTML = "CLAIM YOUR BRUSH";
				this.n__mainClaimBrushButton.style.fontSize = '14px';
				this.n__mainClaimBrushButton.style.fontWeight = '300';
				this.n__mainClaimBrushButton.style.lineHeight = '14px';
				this.n__mainClaimBrushButton.style.paddingLeft = '30px';
				this.n__mainClaimBrushButton.style.paddingRight = '30px';
				this.n__mainClaimBrushButton.style.paddingTop = '15px';
				this.n__mainClaimBrushButton.style.paddingBottom = '15px';
				this.n__mainClaimBrushButton.style.width = '80%';
				this.n__mainClaimBrushButton.style.marginLeft = '9%';
				this.n__mainClaimBrushButton.style.fontFamily = "Montserrat, sans-serif";
				this.n__mainClaimBrushButton.style.cursor = 'pointer';
				this.n__mainClaimBrushButton.style.color = '#ffffff';
				this.n__mainClaimBrushButton.style.backgroundColor = '#4597cb';
				this.n__mainClaimBrushButton.style.border = 'none'
				this.n__mainClaimBrushButton.style.transition = 'all 0.5s ease 0s';
				this.n__mainClaimBrushButton.style.marginBottom = '40px';
				this.n__mainClaimBrushButton.style.marginTop = '10px';
				this.n__mainClaimBrushButton.onclick = function()
				{
					n__smilebrilliantGehaWidgets.n__showLightbox();
					return false;
				}
				this.n__mainClaimBrushButton.onmouseout = function()
				{
					this.style.backgroundColor = '#4597cb';
				}
				this.n__mainClaimBrushButton.onmouseover = function()
				{
					this.style.backgroundColor = '#573160';
				}
				this.n__mainDivWrap.appendChild(this.n__mainClaimBrushButton);

		}catch(err){};


		//SIDBAR WIDGET
		try
		{
			this.n__sidebarDivWrap = document.getElementById("smilebrilliant_geha_widget_sidebar");

			//div wrap
				this.n__sidebarDivWrap.style.overflow = 'hidden';
				this.n__sidebarDivWrap.style.display = 'block';
				this.n__sidebarDivWrap.style.cursor = 'pointer';
				this.n__sidebarDivWrap.style.textDecoration = "none";
				this.n__sidebarDivWrap.style.border = "none";
				this.n__sidebarDivWrap.style.padding = "0px";
				this.n__sidebarDivWrap.style.margin = "0px";
				this.n__sidebarDivWrap.style.fontSize = "0px";
				this.n__sidebarDivWrap.style.lineHeight = "0px";
				this.n__sidebarDivWrap.style.width = '100%';
				this.n__sidebarDivWrap.style.height = '100%';
				this.n__sidebarDivWrap.style.border = 'solid #3c98cc 2px';
				this.n__sidebarDivWrap.style.maxWidth = '192px';
				this.n__sidebarDivWrap.style.maxHeight = 'none';
				this.n__sidebarDivWrap.style.minWidth = 'none';
				this.n__sidebarDivWrap.style.minHeight = 'none';
				this.n__sidebarDivWrap.onclick = function()
				{
					n__smilebrilliantGehaWidgets.n__showLightbox();
					return false;
				}


			//top white banner
				this.n__sidebarTopBanner.innerHTML = "MEMBER EXCLUSIVE";
				this.n__sidebarTopBanner.style.textAlign = "center";
				this.n__sidebarTopBanner.style.paddingTop = "10px";
				this.n__sidebarTopBanner.style.paddingBottom = "10px";
				this.n__sidebarTopBanner.style.fontFamily = "Open Sans, Geneva, Helvetica, Arial, Tahoma, Verdana, sans-serif";
				this.n__sidebarTopBanner.style.fontSize = "15px";
				this.n__sidebarTopBanner.style.letterSpacing = "1px";
				this.n__sidebarTopBanner.style.lineHeight = "15px";
				this.n__sidebarTopBanner.style.fontWeight = "normal";
				this.n__sidebarTopBanner.style.color = '#555759';
				this.n__sidebarTopBanner.style.backgroundColor = "#fffff";
				this.n__sidebarDivWrap.appendChild(this.n__sidebarTopBanner);


			//top blue banner
				this.n__sidebarTopBannerBlue.innerHTML = "ELECTRIC TOOTHBRUSH";
				this.n__sidebarTopBannerBlue.style.textAlign = "center";
				this.n__sidebarTopBannerBlue.style.paddingTop = "8px";
				this.n__sidebarTopBannerBlue.style.paddingBottom = "8px";
				this.n__sidebarTopBannerBlue.style.fontFamily = "Montserrat, sans-serif";
				this.n__sidebarTopBannerBlue.style.fontSize = "22px";
				this.n__sidebarTopBannerBlue.style.lineHeight = "28px";
				this.n__sidebarTopBannerBlue.style.fontWeight = "bold";
				this.n__sidebarTopBannerBlue.style.color = "white";
				this.n__sidebarTopBannerBlue.style.backgroundColor = "#3c98cc";
				this.n__sidebarDivWrap.appendChild(this.n__sidebarTopBannerBlue);

			//image
				this.n__sidebarImage.src = "https://www.smilebrilliant.com/static/images/product/geha-caripro-offer.jpg";
				this.n__sidebarImage.style.textDecoration = "none";
				this.n__sidebarImage.style.border = "none";
				this.n__sidebarImage.style.padding = "0px";
				this.n__sidebarImage.style.margin = "0px";
				this.n__sidebarImage.style.marginTop = "8px";
				this.n__sidebarImage.style.fontSize = "0px";
				this.n__sidebarImage.style.lineHeight = "0px";
				this.n__sidebarImage.style.maxWidth = "none";
				this.n__sidebarImage.style.minWidth = "none";
				this.n__sidebarImage.style.maxHeight = "none";
				this.n__sidebarImage.style.minHeight = "none";
				this.n__sidebarImage.style.width = "100%";
				this.n__sidebarDivWrap.appendChild(this.n__sidebarImage);


			//primary content
				this.n__sidebarPrimaryContent.innerHTML = "70% OFF cariPRO electric toothbrush exclusively for GEHA members.Limited quantities available.";
				this.n__sidebarPrimaryContent.style.fontSize = '13px';
				this.n__sidebarPrimaryContent.style.lineHeight = '17px';
				this.n__sidebarPrimaryContent.style.textAlign = "center";
				this.n__sidebarPrimaryContent.style.paddingTop = "10px";
				this.n__sidebarPrimaryContent.style.paddingBottom = "10px";
				this.n__sidebarPrimaryContent.style.paddingLeft = "8px";
				this.n__sidebarPrimaryContent.style.paddingRight = "8px";
				this.n__sidebarPrimaryContent.style.fontFamily = "Open Sans, Geneva, Helvetica, Arial, Tahoma, Verdana, sans-serif";
				this.n__sidebarPrimaryContent.style.color = '#555759';
				this.n__sidebarDivWrap.appendChild(this.n__sidebarPrimaryContent);


			//get discount button
				this.n__sidebarButton.innerHTML = "GET DISCOUNT";
				this.n__sidebarButton.style.fontSize = '16px';
				this.n__sidebarButton.style.fontWeight = '300';
				this.n__sidebarButton.style.lineHeight = '16px';
				this.n__sidebarButton.style.paddingLeft = '8px';
				this.n__sidebarButton.style.paddingRight = '8px';
				this.n__sidebarButton.style.paddingTop = '13px';
				this.n__sidebarButton.style.paddingBottom = '13px';
				this.n__sidebarButton.style.width = '90%';
				this.n__sidebarButton.style.marginLeft = '5%';
				this.n__sidebarButton.style.fontFamily = "Montserrat, sans-serif";
				this.n__sidebarButton.style.cursor = 'pointer';
				this.n__sidebarButton.style.color = '#ffffff';
				this.n__sidebarButton.style.backgroundColor = '#4597cb';
				this.n__sidebarButton.style.border = 'none'
				this.n__sidebarButton.style.transition = 'all 0.5s ease 0s';
				this.n__sidebarButton.style.marginBottom = '10px';
				this.n__sidebarButton.style.marginTop = '10px';
				this.n__sidebarButton.onmouseout = function()
				{
					this.style.backgroundColor = '#4597cb';
				}
				this.n__sidebarButton.onmouseover = function()
				{
					this.style.backgroundColor = '#573160';
				}

				this.n__sidebarDivWrap.appendChild(this.n__sidebarButton);

		}catch(err){};

		//HEADER BAR
		try
		{
			var n__headerBarEnabled = false;
			//only if enabled
			try
			{
				if(document.getElementById('smilebrilliant_geha_widget_include').getAttribute('headerbar') == "enabled")
				{
					n__headerBarEnabled = true;
				}
			}catch(err){}

			if(n__headerBarEnabled == true)
			{
				var n__headerDiv = document.getElementsByTagName("header");
				n__headerDiv[0].insertBefore(this.n__headerBarWrap, n__headerDiv[0].firstChild);

				//header bar wrap
					this.n__headerBarWrap.style.backgroundColor = '#3c97cc';
					this.n__headerBarWrap.style.width = '100%';
					this.n__headerBarWrap.style.height = '45px';

				//header bar centered
					this.n__headerBarCentered.style.width = '560px';
					this.n__headerBarCentered.style.margin = '0px auto';
					this.n__headerBarWrap.appendChild(this.n__headerBarCentered);

				//text
					this.n__headerBarText.innerHTML = "CLAIM YOUR ELECTRIC TOOTHBRUSH";
					this.n__headerBarText.style.textAlign = "center";
					this.n__headerBarText.style.paddingTop = "8px";
					this.n__headerBarText.style.paddingBottom = "8px";
					this.n__headerBarText.style.fontFamily = "Montserrat, sans-serif";
					this.n__headerBarText.style.fontSize = "20px";
					this.n__headerBarText.style.lineHeight = "26px";
					this.n__headerBarText.style.fontWeight = "bold";
					this.n__headerBarText.style.color = "white";
					this.n__headerBarText.style.backgroundColor = "#3c98cc";
					this.n__headerBarText.style.cssFloat = 'left';
					this.n__headerBarText.style.styleFloat = 'left';
					this.n__headerBarCentered.appendChild(this.n__headerBarText);

				//button
					this.n__headerBarButton.innerHTML = "CLICK HERE";
					this.n__headerBarButton.style.fontSize = '16px';
					this.n__headerBarButton.style.lineHeight = '16px';
					this.n__headerBarButton.style.cssFloat = 'right';
					this.n__headerBarButton.style.styleFloat = 'right';
					this.n__headerBarButton.style.fontWeight = 'bold';
					this.n__headerBarButton.style.paddingLeft = '16px';
					this.n__headerBarButton.style.paddingRight = '16px';
					this.n__headerBarButton.style.paddingTop = '8px';
					this.n__headerBarButton.style.paddingBottom = '8px';
					this.n__headerBarButton.style.fontFamily = "Montserrat, sans-serif";
					this.n__headerBarButton.style.cursor = 'pointer';
					this.n__headerBarButton.style.color = '#ffffff';
					this.n__headerBarButton.style.backgroundColor = '#ffa489';
					this.n__headerBarButton.style.border = 'none'
					this.n__headerBarButton.style.transition = 'all 0.5s ease 0s';
					this.n__headerBarButton.style.marginTop = '6px';
					this.n__headerBarButton.onclick = function()
					{
						n__smilebrilliantGehaWidgets.n__showLightbox();
					}
					this.n__headerBarButton.onmouseout = function()
					{
						this.style.backgroundColor = '#ffa489';
					}
					this.n__headerBarButton.onmouseover = function()
					{
						this.style.backgroundColor = '#573160';
					}

					this.n__headerBarCentered.appendChild(this.n__headerBarButton);
			}

		}catch(err){}

		//lightbox mask initialized
		try
		{

			this.n__lightboxMask.style.backgroundColor = '#2f2f2f';
			this.n__lightboxMask.style.opacity = '0.6';
			this.n__lightboxMask.style.width = '100%';
			this.n__lightboxMask.style.height = '100%';
			this.n__lightboxMask.style.position = 'fixed';
			this.n__lightboxMask.style.zIndex = '999999';
			this.n__lightboxMask.style.display = 'none';
			this.n__lightboxMask.onclick = function()
			{
				n__smilebrilliantGehaWidgets.n__hideLightbox();
			}

			//append to body
			document.getElementsByTagName("body")[0].insertBefore(this.n__lightboxMask, document.getElementsByTagName("body")[0].firstChild);


			//append pixel requester to mask
			this.n__pixelRequster.src = "";
			this.n__pixelRequster.style.visibility = "hidden";
			this.n__pixelRequster.style.textDecoration = "none";
			this.n__pixelRequster.style.border = "none";
			this.n__pixelRequster.style.padding = "0px";
			this.n__pixelRequster.style.margin = "0px";
			this.n__pixelRequster.style.lineHeight = "0px";
			this.n__pixelRequster.style.height = "0px";
			this.n__pixelRequster.style.width = "0px";
			try {this.n__pixelRequster.style.maxWidth = "none";} catch(err){}
			try {this.n__pixelRequster.style.minWidth = "none";} catch(err){}
			try {this.n__pixelRequster.style.maxHeight = "none";} catch(err){}
			try {this.n__pixelRequster.style.minHeight = "none";} catch(err){}
			this.n__lightboxMask.appendChild(this.n__pixelRequster);

		}catch(err){}

		//LIGHTBOX WIDGET
		try
		{
			//main div wrap
				this.n__lightboxDivWrap.style.overflow = 'hidden';
				this.n__lightboxDivWrap.style.display = 'none';
				this.n__lightboxDivWrap.style.position = 'absolute';
				this.n__lightboxDivWrap.style.zIndex = '9999999';
				this.n__lightboxDivWrap.style.textDecoration = "none";
				this.n__lightboxDivWrap.style.border = "none";
				this.n__lightboxDivWrap.style.padding = "0px";
				this.n__lightboxDivWrap.style.margin = "0px";
				this.n__lightboxDivWrap.style.marginTop = "2%";
				this.n__lightboxDivWrap.style.left = "50%";
				this.n__lightboxDivWrap.style.fontSize = "0px";
				this.n__lightboxDivWrap.style.lineHeight = "0px";
				this.n__lightboxDivWrap.style.border = 'solid #3c98cc 2px';
				this.n__lightboxDivWrap.style.width = '100%';
				this.n__lightboxDivWrap.style.maxWidth = '500px';
				this.n__lightboxDivWrap.style.maxHeight = 'none';
				this.n__lightboxDivWrap.style.minWidth = 'none';
				this.n__lightboxDivWrap.style.minHeight = 'none';
				this.n__lightboxDivWrap.style.backgroundColor = '#ffffff';
				this.n__lightboxDivWrap.style.overflow = 'visible';
				this.n__lightboxDivWrap.style.boxShadow = '0 10px 16px 0 rgba(0,0,0,0.2)';

				//append to body
				document.getElementsByTagName("body")[0].insertBefore(this.n__lightboxDivWrap, document.getElementsByTagName("body")[0].firstChild);

			//close icon
				this.n__lightboxCloseDiv.style.height = '20px';
				this.n__lightboxCloseDiv.style.width = '20px';
				this.n__lightboxCloseDiv.style.position = 'absolute';
				this.n__lightboxCloseDiv.style.cursor = 'pointer';
				this.n__lightboxCloseDiv.style.top = '-10px';
				this.n__lightboxCloseDiv.style.right = '-10px';
				this.n__lightboxCloseDiv.style.zIndex = '99999999';
				this.n__lightboxCloseDiv.innerHTML = "";
				this.n__lightboxCloseDiv.onclick = function()
				{
					n__smilebrilliantGehaWidgets.n__hideLightbox();
				}
				this.n__lightboxDivWrap.appendChild(this.n__lightboxCloseDiv);


			//top blue banner
				this.n__lightboxTopBanner.innerHTML = "ELECTRIC TOOTHBRUSH";
				this.n__lightboxTopBanner.style.textAlign = "center";
				this.n__lightboxTopBanner.style.paddingTop = "15px";
				this.n__lightboxTopBanner.style.paddingBottom = "15px";
				this.n__lightboxTopBanner.style.fontFamily = "Montserrat, sans-serif";
				this.n__lightboxTopBanner.style.fontSize = "32px";
				this.n__lightboxTopBanner.style.lineHeight = "32px";
				this.n__lightboxTopBanner.style.fontWeight = "bold";
				this.n__lightboxTopBanner.style.color = "white";
				this.n__lightboxTopBanner.style.backgroundColor = "#3c98cc";
				this.n__lightboxDivWrap.appendChild(this.n__lightboxTopBanner);

			//top orange banner
				this.n__lightboxTopBannerOrange.innerHTML = "MEMBER EXCLUSIVE DISCOUNT";
				this.n__lightboxTopBannerOrange.style.textAlign = "center";
				this.n__lightboxTopBannerOrange.style.paddingTop = "10px";
				this.n__lightboxTopBannerOrange.style.paddingBottom = "10px";
				this.n__lightboxTopBannerOrange.style.fontFamily = "Open Sans, Geneva, Helvetica, Arial, Tahoma, Verdana, sans-serif";
				this.n__lightboxTopBannerOrange.style.fontSize = "16px";
				this.n__lightboxTopBannerOrange.style.letterSpacing = "1px";
				this.n__lightboxTopBannerOrange.style.lineHeight = "16px";
				this.n__lightboxTopBannerOrange.style.fontWeight = "bold";
				this.n__lightboxTopBannerOrange.style.color = "white";
				this.n__lightboxTopBannerOrange.style.backgroundColor = "#ffa489";
				this.n__lightboxDivWrap.appendChild(this.n__lightboxTopBannerOrange);

			//main image
				this.n__lightboxImage.src = "https://www.smilebrilliant.com/static/images/product/geha-caripro-offer.jpg";
				this.n__lightboxImage.style.textDecoration = "none";
				this.n__lightboxImage.style.border = "none";
				this.n__lightboxImage.style.padding = "0px";
				this.n__lightboxImage.style.margin = "0px";
				this.n__lightboxImage.style.marginTop = "0px";
				this.n__lightboxImage.style.fontSize = "0px";
				this.n__lightboxImage.style.lineHeight = "0px";
				this.n__lightboxImage.style.maxWidth = "none";
				this.n__lightboxImage.style.minWidth = "none";
				this.n__lightboxImage.style.maxHeight = "none";
				this.n__lightboxImage.style.minHeight = "none";
				this.n__lightboxImage.style.width = "100%";
				this.n__lightboxDivWrap.appendChild(this.n__lightboxImage);

			//included with title div
				this.n__lightboxIncludedTitleDiv.innerHTML = "INCLUDED WITH EACH KIT";
				this.n__lightboxIncludedTitleDiv.style.display = 'none';
				this.n__lightboxIncludedTitleDiv.style.fontSize = '18px';
				this.n__lightboxIncludedTitleDiv.style.lineHeight = '21px';
				this.n__lightboxIncludedTitleDiv.style.textAlign = "center";
				this.n__lightboxIncludedTitleDiv.style.paddingTop = "0px";
				this.n__lightboxIncludedTitleDiv.style.paddingBottom = "10px";
				this.n__lightboxIncludedTitleDiv.style.paddingLeft = "10px";
				this.n__lightboxIncludedTitleDiv.style.paddingRight = "10px";
				this.n__lightboxIncludedTitleDiv.style.marginTop = "-10px";
				this.n__lightboxIncludedTitleDiv.style.fontFamily = "Open Sans, Geneva, Helvetica, Arial, Tahoma, Verdana, sans-serif";
				this.n__lightboxIncludedTitleDiv.style.fontWeight = "bold";
				this.n__lightboxIncludedTitleDiv.style.color = '#555759';
				this.n__lightboxDivWrap.appendChild(this.n__lightboxIncludedTitleDiv);

			//included with content div
				this.n__lightboxIncludedContentDiv.innerHTML = "<ul><li>x1 cariPRO Electric  Toothbrush</li> <li>x1 Wireless charging doc</li><li> x2 replacement brush heads w/tongue scraper & DuPont Bristles</li><li> 2 Year limited warranty</ul>";
				//this.n__lightboxIncludedContentDiv.innerHTML = "x1 cariPRO Electric  Toothbrush x1 Wireless charging doc x2 replacement brush heads w/tongue scraper & DuPont Bristles 2-year limited warranty";
				this.n__lightboxIncludedContentDiv.style.display = 'none';
				this.n__lightboxIncludedContentDiv.style.fontSize = '16px';
				this.n__lightboxIncludedContentDiv.style.lineHeight = '22px';
				this.n__lightboxIncludedContentDiv.style.textAlign = "center";
				this.n__lightboxIncludedContentDiv.style.paddingTop = "10px";
				this.n__lightboxIncludedContentDiv.style.paddingBottom = "20px";
				this.n__lightboxIncludedContentDiv.style.paddingLeft = "10px";
				this.n__lightboxIncludedContentDiv.style.paddingRight = "10px";
				this.n__lightboxIncludedContentDiv.style.fontFamily = "Open Sans, Geneva, Helvetica, Arial, Tahoma, Verdana, sans-serif";
				this.n__lightboxIncludedContentDiv.style.fontWeight = "normal";
				this.n__lightboxIncludedContentDiv.style.color = '#555759';
				this.n__lightboxDivWrap.appendChild(this.n__lightboxIncludedContentDiv);

			//step 1 with content div
				this.n__lightboxStep1ContentDiv.innerHTML = "Your GEHA membership gets you 75% OFF premium electric toothbrushes by cariPRO (<?php echo $rand_text;?>). Enter your email address below to claim your toothbrush.Follow these steps to purchase:";
				this.n__lightboxStep1ContentDiv.style.fontSize = '14px';
				this.n__lightboxStep1ContentDiv.style.display = 'none';
				this.n__lightboxStep1ContentDiv.style.lineHeight = '20px';
				this.n__lightboxStep1ContentDiv.style.textAlign = "center";
				this.n__lightboxStep1ContentDiv.style.paddingTop = "10px";
				this.n__lightboxStep1ContentDiv.style.paddingBottom = "20px";
				this.n__lightboxStep1ContentDiv.style.paddingLeft = "20px";
				this.n__lightboxStep1ContentDiv.style.paddingRight = "20px";
				this.n__lightboxStep1ContentDiv.style.fontFamily = "Open Sans, Geneva, Helvetica, Arial, Tahoma, Verdana, sans-serif";
				this.n__lightboxStep1ContentDiv.style.fontWeight = "normal";
				this.n__lightboxStep1ContentDiv.style.color = '#555759';
				this.n__lightboxDivWrap.appendChild(this.n__lightboxStep1ContentDiv);

			//hr div
				this.n__lightboxHRDiv.innerHTML = "";
				this.n__lightboxHRDiv.style.fontSize = '0px';
				this.n__lightboxHRDiv.style.lineHeight = '0px';
				this.n__lightboxHRDiv.style.backgroundColor = '#c5c6c9';
				this.n__lightboxHRDiv.style.height = '1px';
				this.n__lightboxHRDiv.style.marginLeft = '40px';
				this.n__lightboxHRDiv.style.marginRight = '40px';
				this.n__lightboxDivWrap.appendChild(this.n__lightboxHRDiv);

			//step 1 form title
				this.n__lightboxStep1FormTitleDiv.innerHTML = "STEP 1";
				this.n__lightboxStep1FormTitleDiv.style.fontSize = '26px';
				this.n__lightboxStep1FormTitleDiv.style.lineHeight = '30px';
				this.n__lightboxStep1FormTitleDiv.style.textAlign = "center";
				this.n__lightboxStep1FormTitleDiv.style.paddingTop = "20px";
				this.n__lightboxStep1FormTitleDiv.style.paddingBottom = "10px";
				this.n__lightboxStep1FormTitleDiv.style.paddingLeft = "10px";
				this.n__lightboxStep1FormTitleDiv.style.paddingRight = "10px";
				this.n__lightboxStep1FormTitleDiv.style.marginTop = "0px";
				this.n__lightboxStep1FormTitleDiv.style.fontFamily = "Montserrat, sans-serif";
				this.n__lightboxStep1FormTitleDiv.style.fontWeight = "bold";
				this.n__lightboxStep1FormTitleDiv.style.color = '#555759';
				this.n__lightboxDivWrap.appendChild(this.n__lightboxStep1FormTitleDiv);

			//step 1 input label
				this.n__lightboxStep1FormLabelDiv.style.fontSize = '14px';
				this.n__lightboxStep1FormLabelDiv.style.display = 'none';
				this.n__lightboxStep1FormLabelDiv.style.lineHeight = '20px';
				this.n__lightboxStep1FormLabelDiv.style.textAlign = "center";
				this.n__lightboxStep1FormLabelDiv.style.paddingTop = "0px";
				this.n__lightboxStep1FormLabelDiv.style.paddingBottom = "0px";
				this.n__lightboxStep1FormLabelDiv.style.paddingLeft = "10px";
				this.n__lightboxStep1FormLabelDiv.style.paddingRight = "10px";
				this.n__lightboxStep1FormLabelDiv.style.fontFamily = "Open Sans, Geneva, Helvetica, Arial, Tahoma, Verdana, sans-serif";
				this.n__lightboxStep1FormLabelDiv.style.fontWeight = "normal";
				this.n__lightboxDivWrap.appendChild(this.n__lightboxStep1FormLabelDiv);

			//step 1 input
				this.n__lightboxStep1FormInput.placeholder = "";
				this.n__lightboxStep1FormInput.type = "email";
				this.n__lightboxStep1FormInput.style.fontSize = '16px';
				this.n__lightboxStep1FormInput.style.lineHeight = '16px';
				this.n__lightboxStep1FormInput.style.height = '40px';
				this.n__lightboxStep1FormInput.style.width = '70%';
				this.n__lightboxStep1FormInput.style.marginLeft = '15%';
				this.n__lightboxStep1FormInput.style.marginTop = '10px';
				this.n__lightboxStep1FormInput.style.display = 'none';
				this.n__lightboxStep1FormInput.style.textAlign = "center";
				this.n__lightboxStep1FormInput.style.fontFamily = "Open Sans, Geneva, Helvetica, Arial, Tahoma, Verdana, sans-serif";
				this.n__lightboxStep1FormInput.style.fontWeight = "normal";
				this.n__lightboxStep1FormInput.style.color = '#555759';
				this.n__lightboxStep1FormInput.style.border = 'solid #555759 1px';
				this.n__lightboxDivWrap.appendChild(this.n__lightboxStep1FormInput);

			//form wrap div
				this.n__lightboxStep2FormWrapDiv.style.display = 'none';
				this.n__lightboxStep2FormWrapDiv.style.padding = "10px";
				this.n__lightboxStep2FormWrapDiv.style.fontSize = "30px";
				this.n__lightboxStep2FormWrapDiv.style.backgroundColor = "#efefef";
				this.n__lightboxStep2FormWrapDiv.style.marginTop = '20px';
				this.n__lightboxStep2FormWrapDiv.style.marginLeft = '6%';
				this.n__lightboxStep2FormWrapDiv.style.marginRight = '6%';
				this.n__lightboxDivWrap.appendChild(this.n__lightboxStep2FormWrapDiv);


			//price div
				this.n__lightboxStep2PriceEachDiv.style.padding = "10px";
				this.n__lightboxStep2PriceEachDiv.style.fontSize = "22px";
				this.n__lightboxStep2PriceEachDiv.style.lineHeight = "22px";
				this.n__lightboxStep2PriceEachDiv.style.fontFamily = "Montserrat, sans-serif";
				this.n__lightboxStep2PriceEachDiv.style.fontWeight = "bold";				
				this.n__lightboxStep2PriceEachDiv.innerHTML = "<div><?php echo $shippingText;?><?php echo $price_only;?> ea</div><div style='font-size:0.6em;font-weight:normal;'>Regularly $119.00</div>";
				this.n__lightboxStep2PriceEachDiv.style.color = "#555759";
				this.n__lightboxStep2PriceEachDiv.style.textAlign = "center";
				this.n__lightboxStep2PriceEachDiv.style.cssFloat = "left";
				this.n__lightboxStep2PriceEachDiv.style.styleFloat = "left";
				this.n__lightboxStep2FormWrapDiv.appendChild(this.n__lightboxStep2PriceEachDiv);

			//quantity wrap
				this.n__lightboxStep2QuantityDiv.style.width = "110px";
				this.n__lightboxStep2QuantityDiv.style.cssFloat = "right";
				this.n__lightboxStep2QuantityDiv.style.styleFloat = "right";
				this.n__lightboxStep2FormWrapDiv.appendChild(this.n__lightboxStep2QuantityDiv);

				//quantity label
					this.n__lightboxStep2QuantityLabelDiv.style.padding = "0px";
					this.n__lightboxStep2QuantityLabelDiv.style.paddingTop = "10px";
					this.n__lightboxStep2QuantityLabelDiv.style.paddingBottom = "10px";
					this.n__lightboxStep2QuantityLabelDiv.style.fontSize = "12px";
					this.n__lightboxStep2QuantityLabelDiv.style.lineHeight = "12px";
					this.n__lightboxStep2QuantityLabelDiv.innerHTML = "SELECT QUANTITY";
					this.n__lightboxStep2QuantityLabelDiv.style.color = "#555759";
					this.n__lightboxStep2QuantityLabelDiv.style.clear = "both";
					this.n__lightboxStep2QuantityDiv.appendChild(this.n__lightboxStep2QuantityLabelDiv);

				//minus box
					this.n__lightboxStep2InputMinus.innerHTML = "-";
					this.n__lightboxStep2InputMinus.style.height = '42px';
					this.n__lightboxStep2InputMinus.style.width = '34px';
					this.n__lightboxStep2InputMinus.style.fontSize = '30px';
					this.n__lightboxStep2InputMinus.style.lineHeight = '30px';
					this.n__lightboxStep2InputMinus.style.textAlign = 'center';
					this.n__lightboxStep2InputMinus.style.padding = '0px';
					this.n__lightboxStep2InputMinus.style.color = '#9c9d9c';
					this.n__lightboxStep2InputMinus.style.cssFloat = 'left';
					this.n__lightboxStep2InputMinus.style.styleFloat = 'left';
					this.n__lightboxStep2InputMinus.style.backgroundColor = '#f9f9f9';
					this.n__lightboxStep2InputMinus.style.border = 'solid #b8b8b8 1px';
					this.n__lightboxStep2InputMinus.style.transition = 'all 0.5s ease 0s';
					this.n__lightboxStep2InputMinus.onclick = function()
					{
						n__smilebrilliantGehaWidgets.n__incrementQuantity("down");
					}
					this.n__lightboxStep2InputMinus.onmouseout = function()
					{
						this.style.backgroundColor = '#f9f9f9';
						this.style.color = '#9c9d9c';
					}
					this.n__lightboxStep2InputMinus.onmouseover = function()
					{
						this.style.backgroundColor = '#595858';
						this.style.color = '#e4e2e4';
					}
					this.n__lightboxStep2QuantityDiv.appendChild(this.n__lightboxStep2InputMinus);

				//input box
					this.n__lightboxStep2Input.value = "1";
					this.n__lightboxStep2Input.type = "text";
					this.n__lightboxStep2Input.style.height = '40px';
					this.n__lightboxStep2Input.style.width = '40px';
					this.n__lightboxStep2Input.style.border = 'solid #595858 1px';
					this.n__lightboxStep2Input.style.fontSize = '18px';
					this.n__lightboxStep2Input.style.lineHeight = '18px';
					this.n__lightboxStep2Input.style.textAlign = "center";
					this.n__lightboxStep2Input.style.padding = "0px";
					this.n__lightboxStep2Input.style.cssFloat = 'left';
					this.n__lightboxStep2Input.style.styleFloat = 'left';
					this.n__lightboxStep2Input.style.fontFamily = "Open Sans, Geneva, Helvetica, Arial, Tahoma, Verdana, sans-serif";
					this.n__lightboxStep2Input.style.fontWeight = "normal";
					this.n__lightboxStep2Input.style.color = '#555759';
					this.n__lightboxStep2QuantityDiv.appendChild(this.n__lightboxStep2Input);

				//plus box
					this.n__lightboxStep2InputPlus.innerHTML = "+";
					this.n__lightboxStep2InputPlus.style.height = '42px';
					this.n__lightboxStep2InputPlus.style.width = '34px';
					this.n__lightboxStep2InputPlus.style.fontSize = '30px';
					this.n__lightboxStep2InputPlus.style.lineHeight = '30px';
					this.n__lightboxStep2InputPlus.style.textAlign = 'center';
					this.n__lightboxStep2InputPlus.style.padding = '0px';
					this.n__lightboxStep2InputPlus.style.color = '#9c9d9c';
					this.n__lightboxStep2InputPlus.style.cssFloat = 'left';
					this.n__lightboxStep2InputPlus.style.styleFloat = 'left';
					this.n__lightboxStep2InputPlus.style.backgroundColor = '#f9f9f9';
					this.n__lightboxStep2InputPlus.style.border = 'solid #b8b8b8 1px';
					this.n__lightboxStep2InputPlus.style.transition = 'all 0.5s ease 0s';

					this.n__lightboxStep2InputPlus.onclick = function()
					{
						n__smilebrilliantGehaWidgets.n__incrementQuantity("up");
					}

					this.n__lightboxStep2InputPlus.onmouseout = function()
					{
						this.style.backgroundColor = '#f9f9f9';
						this.style.color = '#9c9d9c';
					}
					this.n__lightboxStep2InputPlus.onmouseover = function()
					{
						this.style.backgroundColor = '#595858';
						this.style.color = '#e4e2e4';
					}
					this.n__lightboxStep2QuantityDiv.appendChild(this.n__lightboxStep2InputPlus);


			//step 2 error label
				this.n__lightboxStep2ErrorDiv.style.fontSize = '16px';
				this.n__lightboxStep2ErrorDiv.style.display = 'none';
				this.n__lightboxStep2ErrorDiv.style.color = 'red';
				this.n__lightboxStep2ErrorDiv.innerHTML = 'Please select a quantity.';
				this.n__lightboxStep2ErrorDiv.style.lineHeight = '20px';
				this.n__lightboxStep2ErrorDiv.style.textAlign = "center";
				this.n__lightboxStep2ErrorDiv.style.paddingTop = "10px";
				this.n__lightboxStep2ErrorDiv.style.paddingBottom = "0px";
				this.n__lightboxStep2ErrorDiv.style.paddingLeft = "10px";
				this.n__lightboxStep2ErrorDiv.style.paddingRight = "10px";
				this.n__lightboxStep2ErrorDiv.style.fontFamily = "Open Sans, Geneva, Helvetica, Arial, Tahoma, Verdana, sans-serif";
				this.n__lightboxStep2ErrorDiv.style.fontWeight = "bold";
				this.n__lightboxDivWrap.appendChild(this.n__lightboxStep2ErrorDiv);

			//clear div
				this.n__lightboxStep2FormClear.style.clear = "both";
				this.n__lightboxStep2FormClear.innerHTML = " ";
				this.n__lightboxStep2FormWrapDiv.appendChild(this.n__lightboxStep2FormClear);


			//claim brush button
				this.n__lightboxGetDiscountButton.innerHTML = "GET DISCOUNT";
				this.n__lightboxGetDiscountButton.style.fontSize = '14px';
				this.n__lightboxGetDiscountButton.style.fontWeight = '300';
				this.n__lightboxGetDiscountButton.style.lineHeight = '14px';
				this.n__lightboxGetDiscountButton.style.paddingLeft = '30px';
				this.n__lightboxGetDiscountButton.style.paddingRight = '30px';
				this.n__lightboxGetDiscountButton.style.paddingTop = '15px';
				this.n__lightboxGetDiscountButton.style.paddingBottom = '15px';
				this.n__lightboxGetDiscountButton.style.width = '60%';
				this.n__lightboxGetDiscountButton.style.marginLeft = '20%';
				this.n__lightboxGetDiscountButton.style.fontFamily = "Montserrat, sans-serif";
				this.n__lightboxGetDiscountButton.style.cursor = 'pointer';
				this.n__lightboxGetDiscountButton.style.color = '#ffffff';
				this.n__lightboxGetDiscountButton.style.backgroundColor = '#4597cb';
				this.n__lightboxGetDiscountButton.style.border = 'none'
				this.n__lightboxGetDiscountButton.style.transition = 'all 0.5s ease 0s';
				this.n__lightboxGetDiscountButton.style.marginBottom = '40px';
				this.n__lightboxGetDiscountButton.style.marginTop = '15px';

				this.n__lightboxGetDiscountButton.onmouseout = function()
				{
					this.style.backgroundColor = '#4597cb';
				}
				this.n__lightboxGetDiscountButton.onmouseover = function()
				{
					this.style.backgroundColor = '#573160';
				}
				this.n__lightboxDivWrap.appendChild(this.n__lightboxGetDiscountButton);

		}catch(err){};

		//resize handling
		n__addEventListener( window, "resize", function(){n__smilebrilliantGehaWidgets.n__handleResize();}, false);
	},
	n__incrementQuantity : function(n__direction)
	{
		if(n__direction == "down")
		{
			if(parseInt(this.n__lightboxStep2Input.value) > 1)
			{
				this.n__lightboxStep2Input.value = parseInt(this.n__lightboxStep2Input.value) - 1;
			}
		}
		else
		{
			this.n__lightboxStep2Input.value = parseInt(this.n__lightboxStep2Input.value) + 1;
		}
	},
	n__handleResize : function()
	{
		//if window is less than 500 in size, then make it 90%
		var n__currentWindowState = n__getWindowState();
		if(n__currentWindowState[0] < 520)
		{
			this.n__lightboxDivWrap.style.width = '90%';
			this.n__lightboxDivWrap.style.marginTop = "6%";

			this.n__lightboxIncludedContentDiv.style.fontSize = '13px';
			this.n__lightboxIncludedContentDiv.style.lineHeight = '19px';

			this.n__lightboxStep2PriceEachDiv.style.padding = "10px";
			this.n__lightboxStep2PriceEachDiv.style.paddingTop = "10px";
			this.n__lightboxStep2PriceEachDiv.style.paddingLeft = "10px";
			this.n__lightboxStep2PriceEachDiv.style.textAlign = "center";
			this.n__lightboxStep2PriceEachDiv.style.cssFloat = "none";
			this.n__lightboxStep2PriceEachDiv.style.styleFloat = "none";

			this.n__lightboxStep2QuantityDiv.style.cssFloat = "none";
			this.n__lightboxStep2QuantityDiv.style.styleFloat = "none";
			this.n__lightboxStep2QuantityDiv.style.margin = "0px auto";

			this.n__lightboxStep2QuantityDiv.style.paddingRight= "0px";
		}
		else
		{
			this.n__lightboxDivWrap.style.width = '100%';
			this.n__lightboxDivWrap.style.marginTop = "2%";

			this.n__lightboxIncludedContentDiv.style.fontSize = '15px';
			this.n__lightboxIncludedContentDiv.style.lineHeight = '20px';

			this.n__lightboxStep2PriceEachDiv.style.padding = "10px";
			this.n__lightboxStep2PriceEachDiv.style.paddingTop = "20px";
			this.n__lightboxStep2PriceEachDiv.style.paddingLeft = "30px";
			this.n__lightboxStep2PriceEachDiv.style.textAlign = "center";
			this.n__lightboxStep2PriceEachDiv.style.cssFloat = "left";
			this.n__lightboxStep2PriceEachDiv.style.styleFloat = "left";

			this.n__lightboxStep2QuantityDiv.style.cssFloat = "right";
			this.n__lightboxStep2QuantityDiv.style.styleFloat = "right";
			this.n__lightboxStep2QuantityDiv.style.margin = "0px";
			this.n__lightboxStep2QuantityDiv.style.paddingRight= "30px";
		}

		var n__lightboxWidth = parseInt(this.n__lightboxDivWrap.offsetWidth);
		this.n__lightboxDivWrap.style.marginLeft = "-" + parseInt(n__lightboxWidth/2) + "px";
	},

	n__showLightbox : function()
	{
		this.n__lightboxDivWrap.style.display = 'block';
		this.n__lightboxMask.style.display = 'block';

		this.n__showStep(1);
		this.n__handleResize();
	},
	n__hideLightbox : function()
	{
		this.n__lightboxDivWrap.style.display = 'none';
		this.n__lightboxMask.style.display = 'none';
	},

	n__handleEmailSubmit : function()
	{
		//verify email
		if(!n__checkEmail(this.n__lightboxStep1FormInput.value))
		{
			this.n__lightboxStep1FormLabelDiv.innerHTML = "Please provide valid email address.";
			this.n__lightboxStep1FormLabelDiv.style.color = 'red';
			this.n__lightboxStep1FormLabelDiv.style.fontWeight = 'bold';
			return false;
		}

		//send request
		/*
			var n__param = '?noCache=' + (new Date()).getTime();
			n__param += "&em="+n__urlEncodeString(this.n__lightboxStep1FormInput.value);
			try
			{
				if(typeof localStorage.buyerId != 'undefined' && localStorage.buyerId != "")
				{
					n__param += "&buyerId="+n__urlEncodeString(localStorage.buyerId);
				}
			}catch(err){}

		this.n__pixelRequster.src = "https://www.smilebrilliant.com/requests/request.gehaBrushSignup.php" + n__param;
		*/

		//show step 2 if it is valid
		this.n__showStep(2);
	},

	//takes us to shopping cart
	n__handleShoppingCartSubmit : function()
	{
		if(parseInt(this.n__lightboxStep2Input.value) > 0)
		{
			//hide button
			this.n__lightboxGetDiscountButton.style.display = 'none';

			//show loading message
			this.n__lightboxStep2ErrorDiv.style.display = 'block';
			this.n__lightboxStep2ErrorDiv.innerHTML = 'Redirecting to Smile Brilliant checkout...';
			this.n__lightboxStep2ErrorDiv.style.paddingBottom = '30px';

			//wait second and redirect
			setTimeout(function()
			{
				newurl ='https://www.smilebrilliant.com/checkout-geha/'+n__smilebrilliantGehaWidgets.n__lightboxStep1FormInput.value+"/"+n__urlEncodeString(n__smilebrilliantGehaWidgets.n__lightboxStep2Input.value)+'?free_shipping=<?php echo $free_shipping ?>';
				window.location.href = newurl;
			}, 1000);

			//wait 4 seconds to hide lightbox
			setTimeout(function()
			{
				n__smilebrilliantGehaWidgets.n__hideLightbox();
			}, 4000);

		}
		//no quantity
		else
		{
			//show loading message, but keep button
			this.n__lightboxStep2ErrorDiv.style.display = 'block';
			this.n__lightboxStep2ErrorDiv.style.paddingBottom = "0px";
			this.n__lightboxStep2ErrorDiv.innerHTML = 'Select valid quantity to order.';
		}
	},

	n__showStep : function(n__stepNumber)
	{

		if(n__stepNumber == 1)
		{
			//set input back to 1
			this.n__lightboxStep2Input.value = "1";

			this.n__lightboxStep1ContentDiv.style.display = 'block';
			this.n__lightboxStep1FormLabelDiv.style.display = 'block';
			this.n__lightboxStep1FormInput.style.display = 'block';

			this.n__lightboxGetDiscountButton.style.display = '';
			this.n__lightboxGetDiscountButton.innerHTML = "GET DISCOUNT";
			this.n__lightboxStep1FormTitleDiv.innerHTML = "STEP 1";
			this.n__lightboxIncludedTitleDiv.style.display = 'none';
			this.n__lightboxIncludedContentDiv.style.display = 'none';
			this.n__lightboxStep2ErrorDiv.style.display = 'none';
			this.n__lightboxStep2FormWrapDiv.style.display = 'none';
			this.n__lightboxStep1FormLabelDiv.innerHTML = "Enter Email Address";
			this.n__lightboxStep1FormLabelDiv.style.color = '#555759';
			this.n__lightboxStep1FormLabelDiv.style.fontWeight = 'normal';

			//onkeyup enter detection
			this.n__lightboxStep1FormInput.onkeyup = function(n__event)
			{
				if (n__event.keyCode == 13 )
				{
					n__smilebrilliantGehaWidgets.n__handleEmailSubmit();
  				}
			}

			//set click to step 2
			this.n__lightboxGetDiscountButton.onclick = function()
			{
				n__smilebrilliantGehaWidgets.n__handleEmailSubmit();
			}
		}
		else
		{
			this.n__lightboxStep1ContentDiv.style.display = 'none';
			this.n__lightboxStep1FormLabelDiv.style.display = 'none';
			this.n__lightboxStep1FormInput.style.display = 'none';

			this.n__lightboxStep1FormTitleDiv.innerHTML = "STEP 2: ORDER";
			this.n__lightboxGetDiscountButton.style.display = '';
			this.n__lightboxGetDiscountButton.innerHTML = "ADD TO CART";
			this.n__lightboxIncludedTitleDiv.style.display = 'block';
			this.n__lightboxIncludedContentDiv.style.display = 'block';
			this.n__lightboxStep2ErrorDiv.style.display = 'none';
			this.n__lightboxStep2FormWrapDiv.style.display = 'block';

			//set click to step 2
			this.n__lightboxGetDiscountButton.onclick = function()
			{
				n__smilebrilliantGehaWidgets.n__handleShoppingCartSubmit();
			}

		}
	}

};

n__smilebrilliantGehaWidgets.n__init();
<?php 
	//echo '</pre>'; 
?>
