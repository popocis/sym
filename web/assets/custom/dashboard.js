// @codekit-prepend '../vendor/babel-external-helpers/babel-external-helpers.js';
// @codekit-prepend '../vendor/tether/tether.js'
// @codekit-prepend '../vendor/bootstrap/bootstrap.js'
// @codekit-prepend '../vendor/mousewheel/jquery.mousewheel.js'
// @codekit-prepend '../vendor/asscrollbar/jquery-asScrollbar.js'
// @codekit-prepend '../vendor/asscrollable/jquery-asScrollable.js'
// @codekit-prepend '../vendor/ashoverscroll/jquery-asHoverScroll.js'
// @codekit-prepend '../vendor/waves/waves.js'
// @codekit-prepend '../vendor/switchery/switchery.min.js'
// @codekit-prepend '../vendor/slidepanel/jquery-slidePanel.js'
// @codekit-prepend '../vendor/matchheight/jquery.matchHeight-min.js'
// @codekit-prepend '../vendor/peity/jquery.peity.min.js'
// @codekit-prepend '../vendor/jquery-placeholder/jquery.placeholder.js'
// @codekit-prepend '../vendor/bootstrap-table/bootstrap-table.min.js'
// @codekit-prepend '../vendor/bootstrap-table/extensions/mobile/bootstrap-table-mobile.js'
// @codekit-prepend '../vendor/bootstrap-table/extensions/export/bootstrap-table-export.js'
// @codekit-prepend '../vendor/bootstrap-table/extensions/export/table-export.js'
// @codekit-prepend '../vendor/bootstrap-datepicker/bootstrap-datepicker.js'
// @codekit-prepend '../vendor/select2/select2.full.min.js'
// @codekit-prepend '../vendor/formvalidation/formValidation.min.js'
// @codekit-prepend '../vendor/formvalidation/framework/bootstrap4.min.js'
// @codekit-prepend '../vendor/bootstrap-sweetalert/sweetalert.js'
// @codekit-prepend '../vendor/moment/moment.min.js'
// @codekit-prepend '../vendor/fullcalendar/fullcalendar.js'
// @codekit-prepend '../vendor/fullcalendar/locale/it.js'
// @codekit-prepend '../vendor/jquery-selective/jquery-selective.min.js'
// @codekit-prepend '../vendor/bootstrap-touchspin/bootstrap-touchspin.min.js'
// @codekit-prepend '../vendor/bootbox/bootbox.js'
// @codekit-prepend '../vendor/lodash/lodash.min.js'

// @codekit-prepend '../js/State.js'
// @codekit-prepend '../js/Component.js'
// @codekit-prepend '../js/Plugin.js'
// @codekit-prepend '../js/Base.js'
// @codekit-prepend '../js/Config.js'
// @codekit-prepend '../js/Section/Menubar.js'
// @codekit-prepend '../js/Section/Sidebar.js'
// @codekit-prepend '../js/Section/PageAside.js'
// @codekit-prepend '../js/Plugin/menu.js'

// @codekit-prepend '../js/Site.js'
// @codekit-prepend '../js/Plugin/asscrollable.js'
// @codekit-prepend '../js/Plugin/slidepanel.js'
// @codekit-prepend '../js/Plugin/switchery.js'
// @codekit-prepend '../js/Plugin/matchheight.js'
// @codekit-prepend '../js/Plugin/peity.js'
// @codekit-prepend '../js/Plugin/bootstrap-datepicker.js'
// @codekit-prepend '../js/Plugin/menu.js'
// @codekit-prepend '../js/Plugin/material.js'
// @codekit-prepend '../js/Plugin/select2.js'
// @codekit-prepend '../js/Plugin/editlist.js'
// @codekit-prepend '../js/Plugin/bootbox.js'


$(document).ready(function() {
    Site.run();
    Waves.attach('.page-content .btn-floating', ['waves-light']);
    console.log("custom js loaded");

    $('[data-plugin="datepicker"]').datepicker({weekStart:1});
});












