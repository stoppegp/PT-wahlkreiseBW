<script type="text/javascript">
jQuery(document).ready(function($){
var wahlkreiseBTW, kandidatenBTW;
var wahlkreiseLTW, kandidatenLTW;
$(".wkfBTW_ort").hide();
$(".wkfBTW_bezirk").hide();
$(".wkfBTW_teil").hide();
$(".wkfBTW_wk").hide();
$(".wkfLTW_ort").hide();
$(".wkfLTW_bezirk").hide();
$(".wkfLTW_teil").hide();
$(".wkfLTW_wk").hide();
$.getJSON( "<?php echo  plugin_dir_url(__FILE__); ?>wahlkreiseBTW.json", function( data ) {
    wahlkreiseBTW = data;
    appendSorted(wahlkreiseBTW, ".wkfBTW_kreis");
});
$.getJSON( "<?php echo  plugin_dir_url(__FILE__); ?>kandidatenBTW.json", function( data ) {
    kandidatenBTW = data;
});
$.getJSON( "<?php echo  plugin_dir_url(__FILE__); ?>wahlkreiseLTW.json", function( data ) {
    wahlkreiseLTW = data;
    appendSorted(wahlkreiseLTW, ".wkfLTW_kreis");
});
$.getJSON( "<?php echo  plugin_dir_url(__FILE__); ?>kandidatenLTW.json", function( data ) {
    kandidatenLTW = data;
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
$(".wkfBTW_kreis").change(function(){
	var wkfid = $(this).data('wkfid');
    var opt = $(this).find(":selected").text();
    setKreisBTW(wkfid, opt)
});
$(".wkfBTW_ort").change(function(){
	var wkfid = $(this).data('wkfid');
    var opt = $(this).find(":selected").text();
    var optKreis = $("#wkfBTW_" + wkfid + "_kreis").find(":selected").text();
    setOrtBTW(wkfid, optKreis, opt);
});
$(".wkfBTW_bezirk").change(function(){
	var wkfid = $(this).data('wkfid');
    var opt = $(this).find(":selected").text();
    var optOrt = $("#wkfBTW_" + wkfid + "_ort").find(":selected").text();
    var optKreis = $("#wkfBTW_" + wkfid + "_kreis").find(":selected").text();
    setBezirkBTW(wkfid, optKreis, optOrt, opt);
});
$(".wkfBTW_teil").change(function(){
	var wkfid = $(this).data('wkfid');
    var opt = $(this).find(":selected").text();
    var optBezirk = $("#wkfBTW_" + wkfid + "_bezirk").find(":selected").text();
    var optOrt = $("#wkfBTW_" + wkfid + "_ort").find(":selected").text();
    var optKreis = $("#wkfBTW_" + wkfid + "_kreis").find(":selected").text();
    setTeilBTW(wkfid, optKreis, optOrt, optBezirk, opt);
});
function setKreisBTW(wkfid, kreis) {
    ob = wahlkreiseBTW[kreis];
    $("#wkfBTW_" + wkfid + "_ort").hide();
    $("#wkfBTW_" + wkfid + "_bezirk").hide();
    $("#wkfBTW_" + wkfid + "_teil").hide();
    $("#wkfBTW_" + wkfid + "_wk").hide();
    if (typeof ob == 'object') {
        $("#wkfBTW_" + wkfid + "_ort").find('option').remove().end();
        if (Object.keys(ob).length > 1) {
            $("#wkfBTW_" + wkfid + "_ort").append($('<option>', { text: "- Gemeinde auswählen -" }));
            appendSorted(ob, "#wkfBTW_" + wkfid + "_ort");
            $("#wkfBTW_" + wkfid + "_ort").show();
        } else {
            $.each( ob, function( key, val ) {
                $("#wkfBTW_" + wkfid + "_ort").append($('<option>', { text: key }));
                setOrtBTW(wkfid, kreis, key);
            });
        }
    } else if (typeof ob == 'string') {
        showWKBTW(wkfid, ob);
    }
}
function setOrtBTW(wkfid, kreis, ort) {
    var ob = wahlkreiseBTW[kreis][ort];
    $("#wkfBTW_" + wkfid + "_bezirk").hide();
    $("#wkfBTW_" + wkfid + "_teil").hide();
    $("#wkfBTW_" + wkfid + "_wk").hide();
    if (typeof ob == 'object') {
        $("#wkfBTW_" + wkfid + "_bezirk").find('option').remove().end();
        if (Object.keys(ob).length > 1) {
            $("#wkfBTW_" + wkfid + "_bezirk").append($('<option>', { text: "- Stadtbezirk auswählen -" }));
            appendSorted(ob, "#wkfBTW_" + wkfid + "_bezirk");
            $("#wkfBTW_" + wkfid + "_bezirk").show();
        } else {
            $.each( ob, function( key, val ) {
                $("#wkfBTW_" + wkfid + "_bezirk").append($('<option>', { text: key }));
                setBezirkBTW(wkfid, kreis, ort, key);
            });
        }
    } else if (typeof ob == 'string') {
        showWKBTW(wkfid, ob);
    }
}
function setBezirkBTW(wkfid, kreis, ort, bezirk) {
    var ob = wahlkreiseBTW[kreis][ort][bezirk];
    $("#wkfBTW_" + wkfid + "_teil").hide();
    $("#wkfBTW_" + wkfid + "_wk").hide();
    if (typeof ob == 'object') {
        $("#wkfBTW_" + wkfid + "_teil").find('option').remove().end();
        if (Object.keys(ob).length > 1) {
            $("#wkfBTW_" + wkfid + "_teil").append($('<option>', { text: "- Stadtteil auswählen -" }));
            appendSorted(ob, "#wkfBTW_" + wkfid + "_teil");
            $("#wkfBTW_" + wkfid + "_teil").show();
        } else {
            $.each( ob, function( key, val ) {
                $("#wkfBTW_" + wkfid + "_teil").append($('<option>', { text: key }));
                setTeilBTW(wkfid, kreis, ort, bezirk, key);
            });
        }
    } else if (typeof ob == 'string') {
        showWKBTW(wkfid, ob);
    }
}
function setTeilBTW(wkfid, kreis, ort, bezirk, teil) {
    var ob = wahlkreiseBTW[kreis][ort][bezirk][teil];
    $("#wkfBTW_" + wkfid + "_wk").hide();
    if (typeof ob == 'string') {
        showWKBTW(wkfid, ob);
    }
}
function showWKBTW(wkfid, wk) {
	var text;
	text = "<p><strong>Wahlkreis:</strong> ";
	if ((typeof kandidatenBTW[wk] == "object") && (typeof kandidatenBTW[wk].wk == "string")) {
		text = text + wk + " - " + kandidatenBTW[wk].wk;
	} else {
		text = text + wk;
	}
	text = text + "</p>";
	if ((typeof kandidatenBTW[wk] == "object") && (typeof kandidatenBTW[wk].name == "string")) {
		text = text + "<p><strong>";
		if ((typeof kandidatenBTW[wk].g == "string") && (kandidatenBTW[wk].g == "w")) {
			text = text + "Kandidatin";
		} else {
			text = text + "Kandidat";
		}
		text = text + ":</strong> ";
		if (typeof kandidatenBTW[wk].link == "string") {
			text = text + '<a href="' + kandidatenBTW[wk].link + '">' + kandidatenBTW[wk].name + '</a>';
		} else {
			text = text + kandidatenBTW[wk].name;
		}
		text = text + "</p>";
	} else {
		text = text + "<p>In diesem Wahlkreis ist leider kein Piratenkandidat aufgestellt. <a href=\"https://piratenpartei-bw.de/wp-content/uploads/BTW2017_Baden-Wuerttemberg_Unterstuetzer.pdf\">Du kannst aber für unsere Landesliste unterschreiben</a>.</p>"
	}
	$("#wkfBTW_" + wkfid + "_wk").html(text);	
    $("#wkfBTW_" + wkfid + "_wk").show();
}
$(".wkfLTW_kreis").change(function(){
	var wkfid = $(this).data('wkfid');
    var opt = $(this).find(":selected").text();
    setKreisLTW(wkfid, opt)
});
$(".wkfLTW_ort").change(function(){
	var wkfid = $(this).data('wkfid');
    var opt = $(this).find(":selected").text();
    var optKreis = $("#wkfLTW_" + wkfid + "_kreis").find(":selected").text();
    setOrtLTW(wkfid, optKreis, opt);
});
$(".wkfLTW_bezirk").change(function(){
	var wkfid = $(this).data('wkfid');
    var opt = $(this).find(":selected").text();
    var optOrt = $("#wkfLTW_" + wkfid + "_ort").find(":selected").text();
    var optKreis = $("#wkfLTW_" + wkfid + "_kreis").find(":selected").text();
    setBezirkLTW(wkfid, optKreis, optOrt, opt);
});
$(".wkfLTW_teil").change(function(){
	var wkfid = $(this).data('wkfid');
    var opt = $(this).find(":selected").text();
    var optBezirk = $("#wkfLTW_" + wkfid + "_bezirk").find(":selected").text();
    var optOrt = $("#wkfLTW_" + wkfid + "_ort").find(":selected").text();
    var optKreis = $("#wkfLTW_" + wkfid + "_kreis").find(":selected").text();
    setTeilLTW(wkfid, optKreis, optOrt, optBezirk, opt);
});
function setKreisLTW(wkfid, kreis) {
    ob = wahlkreiseLTW[kreis];
    $("#wkfLTW_" + wkfid + "_ort").hide();
    $("#wkfLTW_" + wkfid + "_bezirk").hide();
    $("#wkfLTW_" + wkfid + "_teil").hide();
    $("#wkfLTW_" + wkfid + "_wk").hide();
    if (typeof ob == 'object') {
        $("#wkfLTW_" + wkfid + "_ort").find('option').remove().end();
        if (Object.keys(ob).length > 1) {
            $("#wkfLTW_" + wkfid + "_ort").append($('<option>', { text: "- Gemeinde auswählen -" }));
            appendSorted(ob, "#wkfLTW_" + wkfid + "_ort");
            $("#wkfLTW_" + wkfid + "_ort").show();
        } else {
            $.each( ob, function( key, val ) {
                $("#wkfLTW_" + wkfid + "_ort").append($('<option>', { text: key }));
                setOrtLTW(wkfid, kreis, key);
            });
        }
    } else if (typeof ob == 'string') {
        showWKLTW(wkfid, ob);
    }
}
function setOrtLTW(wkfid, kreis, ort) {
    var ob = wahlkreiseLTW[kreis][ort];
    $("#wkfLTW_" + wkfid + "_bezirk").hide();
    $("#wkfLTW_" + wkfid + "_teil").hide();
    $("#wkfLTW_" + wkfid + "_wk").hide();
    if (typeof ob == 'object') {
        $("#wkfLTW_" + wkfid + "_bezirk").find('option').remove().end();
        if (Object.keys(ob).length > 1) {
            $("#wkfLTW_" + wkfid + "_bezirk").append($('<option>', { text: "- Stadtbezirk auswählen -" }));
            appendSorted(ob, "#wkfLTW_" + wkfid + "_bezirk");
            $("#wkfLTW_" + wkfid + "_bezirk").show();
        } else {
            $.each( ob, function( key, val ) {
                $("#wkfLTW_" + wkfid + "_bezirk").append($('<option>', { text: key }));
                setBezirkLTW(wkfid, kreis, ort, key);
            });
        }
    } else if (typeof ob == 'string') {
        showWKLTW(wkfid, ob);
    }
}
function setBezirkLTW(wkfid, kreis, ort, bezirk) {
    var ob = wahlkreiseLTW[kreis][ort][bezirk];
    $("#wkfLTW_" + wkfid + "_teil").hide();
    $("#wkfLTW_" + wkfid + "_wk").hide();
    if (typeof ob == 'object') {
        $("#wkfLTW_" + wkfid + "_teil").find('option').remove().end();
        if (Object.keys(ob).length > 1) {
            $("#wkfLTW_" + wkfid + "_teil").append($('<option>', { text: "- Stadtteil auswählen -" }));
            appendSorted(ob, "#wkfLTW_" + wkfid + "_teil");
            $("#wkfLTW_" + wkfid + "_teil").show();
        } else {
            $.each( ob, function( key, val ) {
                $("#wkfLTW_" + wkfid + "_teil").append($('<option>', { text: key }));
                setTeilLTW(wkfid, kreis, ort, bezirk, key);
            });
        }
    } else if (typeof ob == 'string') {
        showWKLTW(wkfid, ob);
    }
}
function setTeilLTW(wkfid, kreis, ort, bezirk, teil) {
    var ob = wahlkreiseLTW[kreis][ort][bezirk][teil];
    $("#wkfLTW_" + wkfid + "_wk").hide();
    if (typeof ob == 'string') {
        showWKLTW(wkfid, ob);
    }
}
function showWKLTW(wkfid, wk) {
	var text;
	text = "<p><strong>Wahlkreis:</strong> ";
	if ((typeof kandidatenLTW[wk] == "object") && (typeof kandidatenLTW[wk].wk == "string")) {
		text = text + wk + " - " + kandidatenLTW[wk].wk;
	} else {
		text = text + wk;
	}
	text = text + "</p>";
	if ((typeof kandidatenLTW[wk] == "object") && (typeof kandidatenLTW[wk].name == "string")) {
		text = text + "<p><strong>";
		if ((typeof kandidatenLTW[wk].g == "string") && (kandidatenLTW[wk].g == "w")) {
			text = text + "Kandidatin";
		} else {
			text = text + "Kandidat";
		}
		text = text + ":</strong> ";
		if (typeof kandidatenLTW[wk].link == "string") {
			text = text + '<a href="' + kandidatenLTW[wk].link + '">' + kandidatenLTW[wk].name + '</a>';
		} else {
			text = text + kandidatenLTW[wk].name;
		}
		text = text + "</p>";
	} else {
		text = text + "<p>In diesem Wahlkreis ist leider kein Piratenkandidat aufgestellt.</p>"
	}
	$("#wkfLTW_" + wkfid + "_wk").html(text);	
    $("#wkfLTW_" + wkfid + "_wk").show();
}
});
</script>
