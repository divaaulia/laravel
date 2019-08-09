$("body").on("click", ".modal-show", function(event) {
    event.preventDefault();

    var me = $(this),
        url = me.attr("href"),
        title = me.attr("title");

    $("#modal-title").text(title);
    $("#modal-btn-save")
        .removeClass("hide")
        .text(me.hasClass("edit") ? "Ubah" : "Simpan");

    $.ajax({
        url: url,
        dataType: "html",
        success: function(response) {
            $("#modal-body").html(response);
        }
    });

    $("#modal").modal("show");
});

$("#modal-btn-save").click(function(event) {
    event.preventDefault();

    var form = $("#modal-body form"),
        url = form.attr("action"),
        method = $("input[name=_method]").val() == undefined ? "POST" : "PUT";

    form.find(".help-block").remove();
    form.find(".form-group").removeClass("has-error");

    $.ajax({
        url: url,
        method: method,
        data: form.serialize(),
        success: function(response) {
            form.trigger("reset");
            $("#modal").modal("hide");
            $("#datatable")
                .DataTable()
                .ajax.reload();

            Swal.fire({
                type: "success",
                title: "Sukses !",
                text: "Data berhasil disimpan !"
            });
        },
        error: function(xhr) {
            var res = xhr.responseJSON;
            if ($.isEmptyObject(res) == false) {
                $.each(res.errors, function(key, value) {
                    $("#" + key)
                        .closest(".form-group")
                        .addClass("has-error")
                        .append(
                            '<span class="help-block"><strong>' +
                                value +
                                "</strong></span>"
                        );
                });
            }
        }
    });
});

$("body").on("click", ".btn-danger", function(event) {
    event.preventDefault();

    var me = $(this),
        url = me.attr("href"),
        title = me.attr("title"),
        csrf_token = $('meta[name="csrf-token"]').attr("content");

    Swal.fire({
        title: "Anda yakin ingin menghapus " + title + " ?",
        type: "warning",
        showCancelButton: true,
        cancelButtonText: "Batal",
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Ya Hapus !"
    }).then(result => {
        if (result.value) {
            $.ajax({
                url: url,
                type: "POST",
                data: {
                    _method: "DELETE",
                    _token: csrf_token
                },
                success: function(response) {
                    $("#datatable")
                        .DataTable()
                        .ajax.reload();
                    Swal.fire({
                        type: "success",
                        title: "Sukses !",
                        text: "Data berhasil dihapus !"
                    });
                },
                error: function(xhr) {
                    Swal.fire({
                        type: "error",
                        title: "Oops...",
                        text: "Ada sesuatu yang salah !"
                    });
                }
            });
        }
    });
});
