// JavaScript Document

	//<![CDATA[
    (function () {
        var useMobile = mobiserver_getQuerystring("UseMobile", null);
            
        if (useMobile == null || useMobile.length == 0) {
            // If no QueryString parameter then check cookies    
            useMobile = mobiserver_getCookie("UseMobile");
        }

        if (useMobile != null && useMobile.length > 0)
        {
            mobiserver_setCookie("UseMobile", useMobile, null);
            if (useMobile == '0' || useMobile.toLowerCase() == 'false') {
                return;
            }
        }

        var siteId = '01AFB832-474D-4A5E-93A3-394D578489E7';            
        var mobiserver = document.createElement('script'); mobiserver.type = 'text/javascript'; //mobiserver.async = true;            
        mobiserver.src = ('https:' == document.location.protocol ? 'https' : 'http') + '://detect.mobi-server.net/2011/06/02/mobiserver_detect_mobile?siteId=' + siteId;

        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(mobiserver, s);
    })();

	function mobiserver_getQuerystring(key, default_) {
        if (default_ == null) default_ = "";
        key = key.replace(/[\[]/, "\\\[").replace(/[\]]/, "\\\]");
        var regex = new RegExp("[\\?&]" + key + "=([^&#]*)");
        var qs = regex.exec(window.location.href);

        if (qs == null)
            return default_;
        else
            return qs[1];
    }

    function mobiserver_getCookie(c_name) {
        if (document.cookie.length > 0) {
            c_start = document.cookie.indexOf(c_name + "=");
            if (c_start != -1) {
                c_start = c_start + c_name.length + 1;
                c_end = document.cookie.indexOf(";", c_start);
                if (c_end == -1) c_end = document.cookie.length;
                return unescape(document.cookie.substring(c_start, c_end));
            }
        }
        return "";
    }

    function mobiserver_setCookie(c_name, value, expiredays) {
        var exdate = new Date();
        exdate.setDate(exdate.getDate() + expiredays);
        document.cookie = c_name + "=" + escape(value) +
            ((expiredays == null) ? "" : ";expires=" + exdate.toGMTString());
    }
	//]]>
