
function passwordCapLow(params) {
    let strings = params;
    let isCap = [];
    let isLow = [];
    for (let i = 0; i < strings.length; i++) {
        let character = strings.charAt(i);
        if (character == character.toUpperCase() && character != character.toLowerCase()) {
            isCap.push(1);
        }
        if (character == character.toLowerCase() && character != character.toUpperCase()) {
            isLow.push(1);
        }
    }
    return isCap.length > 0 && isLow.length > 0;
}

function passwordAngka(params) {
    let strings = params;
    let isAngka = [];
    for (let i = 0; i < strings.length; i++) {
        let character = strings.charAt(i);
        if (Boolean(character.match(/^[0-9]*$/)) && !isNaN(parseInt(character))) {
            isAngka.push(1);
        }
    }
    return isAngka.length > 0;
}

function passwordSymbol(params) {
    let regex = /^(?=.*[.?!@#$%^&*])/;
    return Boolean(params.match(regex));
}

function resetPasswordValidation() {
    $("#is8").css("color", "#6c757d");
    $("#is8Check").hide();
    $("#isCapLow").css("color", "#6c757d");
    $("#isCapLowCheck").hide();
    $("#isAngka").css("color", "#6c757d");
    $("#isAngkaCheck").hide();
    $("#isSymbol").css("color", "#6c757d");
    $("#isSymbolCheck").hide();
    $("#isIdentikX").hide();
    $("#isIdentikJ").hide();
    $("#password").attr("type", "password");
    $("#password-confirm").attr("type", "password");
    $("#kataSandiEye").html('<i class="ti ti-eye"></i>');
    $("#konfirmasiKataSandiEye").html('<i class="ti ti-eye"></i>');
}

function passwordEvent() {
    $(document).on("input", "#password", function () {
        let isWord = $(this).val();
        if (isWord.length >= 8) {
            $("#is8").css("color", "green");
            $("#is8Check").show();
            totalPasswordLine1 = 1;
        } else {
            $("#is8").css("color", "#6c757d");
            $("#is8Check").hide();
            totalPasswordLine1 = 0;
        }
        if (passwordCapLow(isWord)) {
            $("#isCapLow").css("color", "green");
            $("#isCapLowCheck").show();
            totalPasswordLine2 = 1;
        } else {
            $("#isCapLow").css("color", "#6c757d");
            $("#isCapLowCheck").hide();
            totalPasswordLine2 = 0;
        }
        if (passwordAngka(isWord)) {
            $("#isAngka").css("color", "green");
            $("#isAngkaCheck").show();
            totalPasswordLine3 = 1;
        } else {
            $("#isAngka").css("color", "#6c757d");
            $("#isAngkaCheck").hide();
            totalPasswordLine3 = 0;
        }
        if (passwordSymbol(isWord)) {
            $("#isSymbol").css("color", "green");
            $("#isSymbolCheck").show();
            totalPasswordLine4 = 1;
        } else {
            $("#isSymbol").css("color", "#6c757d");
            $("#isSymbolCheck").hide();
            totalPasswordLine4 = 0;
        }
        totalPasswordLine = totalPasswordLine1 + totalPasswordLine2 + totalPasswordLine3 + totalPasswordLine4;
    });
    $(document).on("input", "#password-confirm, #password", function () {
        let password = $("#password").val();
        let passwordConfirm = $("#password-confirm").val();
        if (password != '' && passwordConfirm != '') {
            if (passwordConfirm == password) {
                $('#isIdentikX').hide();
                $('#isIdentikJ').show();
                $("#isIdentikJ").css("color", "green");
                passwordConfirmStatus = 1;
            } else {
                $("#isIdentikX").css("color", "red");
                $('#isIdentikX').show();
                $('#isIdentikJ').hide();
                passwordConfirmStatus = 0;
            }
        } else {
            $('#isIdentikX').hide();
            $('#isIdentikJ').hide();
        }
    });
    let isPassType = "password";
    $(document).on("click", "#kataSandiEye", function () {
        let isHtml = '<i class="ti ti-eye"></i>';
        if (isPassType == "password") {
            isPassType = "text";
            isHtml = '<i class="ti ti-eye-off"></i>';
        } else {
            isPassType = "password";
            isHtml = '<i class="ti ti-eye"></i>';
        }
        $("#password").attr("type", isPassType);
        $(this).html(isHtml);
    });
    let isPassConfType = "password";
    $(document).on("click", "#konfirmasiKataSandiEye", function () {
        let isHtml = '<i class="ti ti-eye"></i>';
        if (isPassConfType == "password") {
            isPassConfType = "text";
            isHtml = '<i class="ti ti-eye-off"></i>';
        } else {
            isPassConfType = "password";
            isHtml = '<i class="ti ti-eye"></i>';
        }
        $("#password-confirm").attr("type", isPassConfType);
        $(this).html(isHtml);
    });
}
