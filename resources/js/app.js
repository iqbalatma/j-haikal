import './bootstrap';
import jQuery from "jquery";
import DataTable from "datatables.net-bs5";

window.$ = jQuery
window.DataTable = DataTable

$(document).ready(function () {
    let defaultDeleteUrl = $("#form-delete").attr("action");
    $(document).on("click", ".btn-delete", function () {
        const id = $(this).data("id");
        changeFormUrlWithId(id, defaultDeleteUrl, "#form-delete")
    })

    new DataTable('#restock');
    new DataTable('#supplier');
    new DataTable('#product');
});
