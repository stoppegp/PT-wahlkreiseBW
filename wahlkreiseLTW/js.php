<script type="text/javascript">
<!--
var wahlkreise, kandidaten;
$(".wkf_ort").hide();
$(".wkf_bezirk").hide();
$(".wkf_teil").hide();
$(".wkf_wk").hide();
$.getJSON( "<?php echo  plugin_dir_url(__FILE__); ?>wahlkreise.json", function( data ) {
    wahlkreise = data;
    appendSorted(wahlkreise, ".wkf_kreis");
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
$(".wkf_kreis").change(function(){
	var wkfid = $(this).data('wkfid');
    var opt = $(this).find(":selected").text();
    setKreis(wkfid, opt)
});
$(".wkf_ort").change(function(){
	var wkfid = $(this).data('wkfid');
    var opt = $(this).find(":selected").text();
    var optKreis = $("#wkf_" + wkfid + "_kreis").find(":selected").text();
    setOrt(wkfid, optKreis, opt);
});
$(".wkf_bezirk").change(function(){
	var wkfid = $(this).data('wkfid');
    var opt = $(this).find(":selected").text();
    var optOrt = $("#wkf_" + wkfid + "_ort").find(":selected").text();
    var optKreis = $("#wkf_" + wkfid + "_kreis").find(":selected").text();
    setBezirk(wkfid, optKreis, optOrt, opt);
});
$(".wkf_teil").change(function(){
	var wkfid = $(this).data('wkfid');
    var opt = $(this).find(":selected").text();
    var optBezirk = $("#wkf_" + wkfid + "_bezirk").find(":selected").text();
    var optOrt = $("#wkf_" + wkfid + "_ort").find(":selected").text();
    var optKreis = $("#wkf_" + wkfid + "_kreis").find(":selected").text();
    setTeil(wkfid, optKreis, optOrt, optBezirk, opt);
});
function setKreis(wkfid, kreis) {
    ob = wahlkreise[kreis];
    $("#wkf_" + wkfid + "_ort").hide();
    $("#wkf_" + wkfid + "_bezirk").hide();
    $("#wkf_" + wkfid + "_teil").hide();
    $("#wkf_" + wkfid + "_wk").hide();
    if (typeof ob == 'object') {
        $("#wkf_" + wkfid + "_ort").find('option').remove().end();
        if (Object.keys(ob).length > 1) {
            $("#wkf_" + wkfid + "_ort").append($('<option>', { text: "- Gemeinde auswählen -" }));
            appendSorted(ob, "#wkf_" + wkfid + "_ort");
            $("#wkf_" + wkfid + "_ort").show();
        } else {
            $.each( ob, function( key, val ) {
                $("#wkf_" + wkfid + "_ort").append($('<option>', { text: key }));
                setOrt(wkfid, kreis, key);
            });
        }
    } else if (typeof ob == 'string') {
        showWK(wkfid, ob);
    }
}
function setOrt(wkfid, kreis, ort) {
    var ob = wahlkreise[kreis][ort];
    $("#wkf_" + wkfid + "_bezirk").hide();
    $("#wkf_" + wkfid + "_teil").hide();
    $("#wkf_" + wkfid + "_wk").hide();
    if (typeof ob == 'object') {
        $("#wkf_" + wkfid + "_bezirk").find('option').remove().end();
        if (Object.keys(ob).length > 1) {
            $("#wkf_" + wkfid + "_bezirk").append($('<option>', { text: "- Stadtbezirk auswählen -" }));
            appendSorted(ob, "#wkf_" + wkfid + "_bezirk");
            $("#wkf_" + wkfid + "_bezirk").show();
        } else {
            $.each( ob, function( key, val ) {
                $("#wkf_" + wkfid + "_bezirk").append($('<option>', { text: key }));
                setBezirk(wkfid, kreis, ort, key);
            });
        }
    } else if (typeof ob == 'string') {
        showWK(wkfid, ob);
    }
}
function setBezirk(wkfid, kreis, ort, bezirk) {
    var ob = wahlkreise[kreis][ort][bezirk];
    $("#wkf_" + wkfid + "_teil").hide();
    $("#wkf_" + wkfid + "_wk").hide();
    if (typeof ob == 'object') {
        $("#wkf_" + wkfid + "_teil").find('option').remove().end();
        if (Object.keys(ob).length > 1) {
            $("#wkf_" + wkfid + "_teil").append($('<option>', { text: "- Stadtteil auswählen -" }));
            appendSorted(ob, "#wkf_" + wkfid + "_teil");
            $("#wkf_" + wkfid + "_teil").show();
        } else {
            $.each( ob, function( key, val ) {
                $("#wkf_" + wkfid + "_teil").append($('<option>', { text: key }));
                setTeil(wkfid, kreis, ort, bezirk, key);
            });
        }
    } else if (typeof ob == 'string') {
        showWK(wkfid, ob);
    }
}
function setTeil(wkfid, kreis, ort, bezirk, teil) {
    var ob = wahlkreise[kreis][ort][bezirk][teil];
    $("#wkf_" + wkfid + "_wk").hide();
    if (typeof ob == 'string') {
        showWK(wkfid, ob);
    }
}
function showWK(wkfid, wk) {
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
	$("#wkf_" + wkfid + "_wk").html(text);	
    $("#wkf_" + wkfid + "_wk").show();
}
//-->
</script>
