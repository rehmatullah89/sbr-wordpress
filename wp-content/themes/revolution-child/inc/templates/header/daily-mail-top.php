
<style>
    body{
        padding-top: 60px; 
    }
    #sale-header-orange{
        background: #f8a18a;
        padding: 20px;
        position: fixed;
        top: 0;
        width: 100%;
        left: 0;
        right: 0;
        z-index: 9999;        
        height:60px;
        display: flex;
    align-items: center;
    justify-content: center;        
    }
    #sale-header-orange a{
        font-family: 'Montserrat', 'BlinkMacSystemFont', -apple-system, 'Roboto', 'Lucida Sans';    
        font-size: 24px; color:#fff;    
    }    
    .fixed-header-on .header{
        top: 60px;
    }
    @media (min-width: 768px){
        #sale-header-orange  .show-mobile{ display:none}
    }    


@media (max-width: 767px){
    body{
        padding-top: 60px;
    }
    #sale-header-orange a{
        font-size: 22px;
        line-height: 1;        
    }
    #sale-header-orange .mobile-hidden{display:none;}
    #sale-header-orange{    z-index: 99;}
}


</style>
<div class="header-sale text-center" id="sale-header-orange" style="background:#f8a18a;">
    <a href="/subscriber-exclusive-deals"><strong>SUBSCRIBER USER?</strong> <br class="show-mobile"><span style="font-weight:300;"> <span class="mobile-hidden"> >> </span> SEE THE DEALS</span></a>
</div>
