// تهيئة KTMenu
KTMenu.init();

// إضافة مستمع حدث النقر لأزرار الحذف
document
    .querySelectorAll('[data-kt-action="delete_row"]')
    .forEach(function (element) {
        element.addEventListener("click", function () {
            Swal.fire({
                text: "هل أنت متأكد أنك تريد الحذف؟",
                icon: "warning",
                buttonsStyling: false,
                showCancelButton: true,
                confirmButtonText: "نعم",
                cancelButtonText: "لا",
                customClass: {
                    confirmButton: "btn btn-danger",
                    cancelButton: "btn btn-secondary",
                },
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.dispatch("delete_order", [
                        this.getAttribute("data-kt-order-id"),
                    ]);
                }
            });
        });
    });


// إضافة مستمع حدث النقر لأزرار التحديث
document
    .querySelectorAll('[data-kt-action="update_row"]')
    .forEach(function (element) {

        element.addEventListener("click", function () {
            console.log(this.getAttribute("data-kt-order-id"));
            Livewire.dispatch("editOrder", [
                this.getAttribute("data-kt-order-id"),
            ]);
        });
    });

// الاستماع لحدث 'success' المرسل من Livewire
Livewire.on("success", (message) => {
    // إعادة تحميل جدول البيانات orders-table
    LaravelDataTables["orders-table"].ajax.reload();
});
