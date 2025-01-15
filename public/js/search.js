$(document).ready(function () {
    let searchTimeout;

    $("#employeeSearch").on("input", function () {
        clearTimeout(searchTimeout);
        const searchTerm = $(this).val();

        if (searchTerm.length >= 3) {
            searchTimeout = setTimeout(() => {
                $.ajax({
                    url: `/api/search-employees`,
                    method: "GET",
                    data: { search: searchTerm },
                    success: function (data) {
                        if (data.length > 0) {
                            const employee = data[0];
                            $("#employee_id").val(employee.id);
                            $("#nome").val(employee.nome);
                            $("#matricula").val(employee.matricula);
                            $("#cargo").val(employee.cargo);
                            $("#employeeInfo").show();
                        }
                    },
                });
            }, 500);
        }
    });

    $("#variableSearch").on("input", function () {
        clearTimeout(searchTimeout);
        const searchTerm = $(this).val();

        if (searchTerm.length >= 2) {
            searchTimeout = setTimeout(() => {
                $.ajax({
                    url: `/api/search-variables`,
                    method: "GET",
                    data: { search: searchTerm },
                    success: function (data) {
                        if (data.length > 0) {
                            const variable = data[0];
                            $("#variable_id").val(variable.id);
                            $("#descricao").val(variable.descricao);
                        }
                    },
                });
            }, 500);
        }
    });
});
