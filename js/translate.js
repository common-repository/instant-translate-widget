// Load within the Window stack

(function () {
    google.load("language", "1");
})();

function translate(lang) {
    if(!lang) {
        lang = "en";
    }
    var translateData = {
            languageCookie: false,
            translatableClass: ""
        };

    if(window.translateData != undefined) {
	translateData = window.translateData;
    }

    $(translateData.translatableClass)
    .each(function (i, n) {
        var txt = $(this).html(), self = this;

        // Store orig data
        if(jQuery.data(this, "orig") == null) {
            jQuery.data(this, "orig", txt);
        }
        else {
            txt = jQuery.data(this, "orig");
        }

        google.language.detect(txt, function(result) {
            if(!result.error && result.language && result.language != lang) {
                google.language.translate(txt, result.language, lang, function (result) {

		    /*
		     * version 1.2 introduced text transition animation opts
		     */
		    textTransition(self, translateData.animation, result.translation);
                });
            }
	    // Restore orig text
	    else if(result.language == lang) {
		// Going from same language to same language?
		google.language.detect($(self).html(), function(result) {
		    if(result.language == lang) {
			textTransition(self, "none", txt);
		    }
		    else {
			textTransition(self, translateData.animation, txt);
		    }
		});
	    }
        });
    });

    // Set the language translated to, if the option is set
    if(translateData.languageCookie) {
        setCookie("storedLanguage", lang, 365);
    }
}
function textTransition(obj, animation, txt) {
    switch(animation) {
	case "fade":
	    $(obj).fadeOut("normal", function () {
		$(this).html(txt);
		$(this).fadeIn("normal");
	    });
	break;
	default:
	case "none":
	    $(obj).html(txt);
	break;
    }
    return true;
}
// Capture change events against the language selector
$(document).ready(function () {
    // Create language opts
    var opts = google.language.Languages, buffer = "";

    for(i in opts) {
        var sel = "";

        if(opts[i] == "" || !google.language.isTranslatable(opts[i])) {
            continue;
        }
        if(opts[i] == "en") {
            sel = "selected='selected'";
        }
        buffer += "<option value='" + opts[i] + "' "+sel+">" + i + "</option>";
    }


    $("select#language").change(function () {
        var sel = $(this).children(":selected");

        translate($(sel).val());
    })
    // Add opts
    .append(buffer)
    // Google branding container
    .after("<div id='googleBranding'></div>");

    // Attach google branding
    google.language.getBranding('googleBranding');

    // Load the stored language to translate to
    if(window.translateData && window.translateData.languageCookie) {
        var storedLanguage = getCookie("storedLanguage");
        if(storedLanguage == "") {
            storedLanguage = "en";
        }
        translate(storedLanguage, window.translateData);

        // Select the loaded language
        $("select#language").val(storedLanguage);
    }


});
/**
 * set and get cookie taken from w3schools.org
 * @see http://www.w3schools.com/JS/js_cookies.asp
 */
function setCookie(c_name,value,expiredays)
{
    var exdate=new Date();
    exdate.setDate(exdate.getDate()+expiredays);
    document.cookie=c_name+ "=" +escape(value)+
    ((expiredays==null) ? "" : ";expires="+exdate.toUTCString());
}

function getCookie(c_name)
{
    if (document.cookie.length>0)
    {
        c_start=document.cookie.indexOf(c_name + "=");
        if (c_start!=-1)
        {
            c_start=c_start + c_name.length+1;
            c_end=document.cookie.indexOf(";",c_start);
            if (c_end==-1) c_end=document.cookie.length;
            return unescape(document.cookie.substring(c_start,c_end));
        }
    }
    return "";
}
