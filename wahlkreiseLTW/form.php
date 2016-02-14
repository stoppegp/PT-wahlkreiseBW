<p><select id="wkf_kreis" style="display:block;margin-top:5px;">
<option>- Kreis auswählen -</option>
</select><select style="display:block;margin-top:5px;" id="wkf_ort">
<option>- bitte auswählen -</option>
</select><select style="display:block;margin-top:5px;" id="wkf_bezirk">
<option>- bitte auswählen -</option>
</select><select style="display:block;margin-top:5px;" id="wkf_teil">
<option>- bitte auswählen -</option>
</select></p>
<div id="wkf_wk"></div>
<script type="text/javascript">
<!--
var wahlkreise, kandidaten;
$("#wkf_ort").hide();
$("#wkf_bezirk").hide();
$("#wkf_teil").hide();
$("#wkf_wk").hide();
$.getJSON( "<?php echo  plugin_dir_url(__FILE__); ?>wahlkreise.json", function( data ) {
    wahlkreise = data;
    appendSorted(wahlkreise, "#wkf_kreis");
});
$.getJSON( "<?php echo  plugin_dir_url(__FILE__); ?>kandidaten.json", function( data ) {
    kandidaten = data;
});
function appendSorted(obj, sel) {
    var keys = Object.keys(obj);
    var i, len = keys.length;
    keys.sort();
    for (i = 0; i < len; i++) {
        k = keys[i];
        $(sel).append($('<option>', { text: k }));
    }
}
$("#wkf_kreis").change(function(){
    var opt = $(this).find(":selected").text();
    setKreis(opt)
});
$("#wkf_ort").change(function(){
    var opt = $(this).find(":selected").text();
    var optKreis = $("#wkf_kreis").find(":selected").text();
    setOrt(optKreis, opt);
});
$("#wkf_bezirk").change(function(){
    var opt = $(this).find(":selected").text();
    var optOrt = $("#wkf_ort").find(":selected").text();
    var optKreis = $("#wkf_kreis").find(":selected").text();
    setBezirk(optKreis, optOrt, opt);
});
$("#wkf_teil").change(function(){
    var opt = $(this).find(":selected").text();
    var optBezirk = $("#wkf_bezirk").find(":selected").text();
    var optOrt = $("#wkf_ort").find(":selected").text();
    var optKreis = $("#wkf_kreis").find(":selected").text();
    setTeil(optKreis, optOrt, optBezirk, opt);
});
function setKreis(kreis) {
    ob = wahlkreise[kreis];
    $("#wkf_ort").hide();
    $("#wkf_bezirk").hide();
    $("#wkf_teil").hide();
    $("#wkf_wk").hide();
    if (typeof ob == 'object') {
        $('#wkf_ort').find('option').remove().end();
        if (Object.keys(ob).length > 1) {
            $('#wkf_ort').append($('<option>', { text: "- Gemeinde auswählen -" }));
            appendSorted(ob, "#wkf_ort");
            $("#wkf_ort").show();
        } else {
            $.each( ob, function( key, val ) {
                $('#wkf_ort').append($('<option>', { text: key }));
                setOrt(kreis, key);
            });
        }
    } else if (typeof ob == 'string') {
        showWK(ob);
    }
}
function setOrt(kreis, ort) {
    var ob = wahlkreise[kreis][ort];
    $("#wkf_bezirk").hide();
    $("#wkf_teil").hide();
    $("#wkf_wk").hide();
    if (typeof ob == 'object') {
        $('#wkf_bezirk').find('option').remove().end();
        if (Object.keys(ob).length > 1) {
            $('#wkf_bezirk').append($('<option>', { text: "- Stadtbezirk auswählen -" }));
            appendSorted(ob, "#wkf_bezirk");
            $("#wkf_bezirk").show();
        } else {
            $.each( ob, function( key, val ) {
                $('#wkf_bezirk').append($('<option>', { text: key }));
                setBezirk(kreis, ort, key);
            });
        }
    } else if (typeof ob == 'string') {
        showWK(ob);
    }
}
function setBezirk(kreis, ort, bezirk) {
    var ob = wahlkreise[kreis][ort][bezirk];
    $("#wkf_teil").hide();
    $("#wkf_wk").hide();
    if (typeof ob == 'object') {
        $('#wkf_teil').find('option').remove().end();
        if (Object.keys(ob).length > 1) {
            $('#wkf_teil').append($('<option>', { text: "- Stadtteil auswählen -" }));
            appendSorted(ob, "#wkf_teil");
            $("#wkf_teil").show();
        } else {
            $.each( ob, function( key, val ) {
                $('#wkf_teil').append($('<option>', { text: key }));
                setTeil(kreis, ort, bezirk, key);
            });
        }
    } else if (typeof ob == 'string') {
        showWK(ob);
    }
}
function setTeil(kreis, ort, bezirk, teil) {
    var ob = wahlkreise[kreis][ort][bezirk][teil];
    $("#wkf_wk").hide();
    if (typeof ob == 'string') {
        showWK(ob);
    }
}
function showWK(wk) {
	var text;
	text = "<p><strong>Wahlkreis:</strong> ";
	if ((typeof kandidaten[wk] == "object") && (typeof kandidaten[wk].wk == "string")) {
		text = text + wk + " - " + kandidaten[wk].wk;
	} else {
		text = text + wk;
	}
	text = text + "</p>";
	if ((typeof kandidaten[wk] == "object") && (typeof kandidaten[wk].name == "string")) {
		text = text + "<p><strong>";
		if ((typeof kandidaten[wk].g == "string") && (kandidaten[wk].g == "w")) {
			text = text + "Kandidatin";
		} else {
			text = text + "Kandidat";
		}
		text = text + ":</strong> ";
		if (typeof kandidaten[wk].link == "string") {
			text = text + '<a href="' + kandidaten[wk].link + '">' + kandidaten[wk].name + '</a>';
		} else {
			text = text + kandidaten[wk].name;
		}
		text = text + "</p>";
	} else {
		text = text + "<p>In diesem Wahlkreis ist leider kein Piratenkandidat aufgestellt.</p>"
	}
	$("#wkf_wk").html(text);	
    $("#wkf_wk").show();
}
//-->
</script>
