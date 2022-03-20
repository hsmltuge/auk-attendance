"use strict";
$.fn.sort_select_box = function () {
  var my_options = $("#" + this.attr("id") + " option");
  my_options.sort(function (a, b) {
    if (a.text > b.text) return 1;
    else if (a.text < b.text) return -1;
    else return 0;
  });
  return my_options;
};
// Class Definition
var KTLogin = (function () {
  var _buttonSpinnerClasses = "spinner spinner-right spinner-white pr-15";

  if ($("#orcid").attr("old") !== "" && $("#orcid").attr("old") !== "No") {
    $(".orcidurl").html(
      `<input value="${$("#orcid").attr(
        "old"
      )}" class="form-control h-auto py-7 px-6 rounded-lg border-1" type="text" id="title" autocomplete="off" name="orcidurl" placeholder="URL to Your ORCID Account"/>`
    );
    $("#orcid").removeAttr("name");
  }

  if (
    $("#academia").attr("old") !== "" &&
    $("#academia").attr("old") !== "No"
  ) {
    $(".academiaurl").html(
      `<input value="${$("#academia").attr(
        "old"
      )}" class="form-control h-auto py-7 px-6 rounded-lg border-1" type="text" name="academiaurl" autocomplete="off" placeholder="URL to Academia Account"/>`
    );
    $("#academia").removeAttr("name");
  }

  if (
    $("#googleschoolar").attr("old") !== "" &&
    $("#googleschoolar").attr("old") !== "No"
  ) {
    $(".googlescholarurl").html(
      `<input value="${$("#googleschoolar").attr(
        "old"
      )}" class="form-control h-auto py-7 px-6 rounded-lg border-1" type="text"  name ="googlescholarurl" autocomplete="off" placeholder="URL to Google Scholar Account"/>`
    );
    $("#googleschoolar").removeAttr("name");
  }

  if (
    $("#researchgate").attr("old") !== "" &&
    $("#researchgate").attr("old") !== "No"
  ) {
    $(".researchgateurl").html(
      `<input value="${$("#researchgate").attr(
        "old"
      )}" class="form-control h-auto py-7 px-6 rounded-lg border-1" type="text" name="researchgateurl" autocomplete="off" placeholder="URL to Research Gate Account"/>`
    );
    $("#researchgate").removeAttr("name");
  }

  $("#orcid").change((e) => {
    if ($(e.target).val() === "Yes") {
      $(".orcidurl").html(
        `<input class="form-control h-auto py-7 px-6 rounded-lg border-1" type="text" id="title" autocomplete="off" name="orcidurl" placeholder="URL to Your ORCID Account"/>`
      );
      $(e.target).removeAttr("name");
      return;
    } else {
      $(".orcidurl").html("");
      $(e.target).attr("name", "orcidurl");
    }
  });

  $("#academia").change((e) => {
    if ($(e.target).val() === "Yes") {
      $(".academiaurl").html(
        `<input class="form-control h-auto py-7 px-6 rounded-lg border-1" type="text" name="academiaurl" autocomplete="off" placeholder="URL to Academia Account"/>`
      );
      $(e.target).removeAttr("name");
      return;
    } else {
      $(".academiaurl").html("");
      $(e.target).attr("name", "academiaurl");
    }
  });

  $("#googleschoolar").change((e) => {
    if ($(e.target).val() === "Yes") {
      $(".googlescholarurl").html(
        `<input class="form-control h-auto py-7 px-6 rounded-lg border-1" type="text"  name ="googlescholarurl" autocomplete="off" placeholder="URL to Google Scholar Account"/>`
      );
      $(e.target).removeAttr("name");
      return;
    } else {
      $(".googlescholarurl").html("");
      $(e.target).attr("name", "googlescholarurl");
    }
  });

  $("#researchgate").change((e) => {
    if ($(e.target).val() === "Yes") {
      $(".researchgateurl").html(
        `<input class="form-control h-auto py-7 px-6 rounded-lg border-1" type="text" name="researchgateurl" autocomplete="off" placeholder="URL to Research Gate Account"/>`
      );
      $(e.target).removeAttr("name");
    } else {
      $(".researchgateurl").html("");
      $(e.target).attr("name", "researchgateurl");
    }
  });

  var SubmitSiwesForm = function () {
    var form = KTUtil.getById("kt_register_form");
    var formSubmitUrl = KTUtil.attr(form, "action");
    var formSubmitButton = KTUtil.getById("kt_register_form_submit_button");

    if (!form) {
      return;
    }
    FormValidation.formValidation(form, {
      fields: {
        academiaurl: {
          validators: {
            notEmpty: {
              message: "Answer is required",
            },
          },
        },
        googlescholarurl: {
          validators: {
            notEmpty: {
              message: "Answer is required",
            },
          },
        },
        researchgateurl: {
          validators: {
            notEmpty: {
              message: "Answer is required",
            },
          },
        },
        orcidurl: {
          validators: {
            notEmpty: {
              message: "Answer is required",
            },
          },
        },
      },
      plugins: {
        trigger: new FormValidation.plugins.Trigger(),
        submitButton: new FormValidation.plugins.SubmitButton(),
        //defaultSubmit: new FormValidation.plugins.DefaultSubmit(), // Uncomment this line to enable normal button submit after form validation
        bootstrap: new FormValidation.plugins.Bootstrap({
          //	eleInvalidClass: '', // Repace with uncomment to hide bootstrap validation icons
          //	eleValidClass: '',   // Repace with uncomment to hide bootstrap validation icons
        }),
      },
    })
      .on("core.form.valid", function () {
        // Show loading state on button
        KTUtil.btnWait(formSubmitButton, _buttonSpinnerClasses, "Please wait");
        // Form Validation & Ajax Submission: https://formvalidation.io/guide/examples/using-ajax-to-submit-the-form
        FormValidation.utils
          .fetch(formSubmitUrl, {
            method: "POST",
            dataType: "json",
            params: {
              orcidurl: form.querySelector('[name="orcidurl"]').value,
              academiaurl: form.querySelector('[name="academiaurl"]').value,
              googlescholarurl: form.querySelector('[name="googlescholarurl"]')
                .value,
              researchgateurl: form.querySelector('[name="researchgateurl"]')
                .value,
              othertools: form.querySelector('[name="othertools"]').value,
            },
          })
          .then(function (response) {
            // Return valid JSON
            // Release button
            KTUtil.btnRelease(formSubmitButton);
            if (response.type === "success" || response.type === "no File") {
              Swal.fire({
                text: "Your record uploaded successfully",
                icon: "success",
                buttonsStyling: false,
                confirmButtonText: "Ok, got it!",
                customClass: {
                  confirmButton: "btn font-weight-bold btn-light-primary",
                },
              }).then(() => {
                location.href = "social.php";
              });
            } else {
              Swal.fire({
                text: response.msg,
                icon: "error",
                buttonsStyling: false,
                confirmButtonText: "Ok, got it!",
                customClass: {
                  confirmButton: "btn font-weight-bold btn-light-primary",
                },
              });
            }
          });
      })
      .on("core.form.invalid", function () {
        Swal.fire({
          text: "Sorry, looks like there are some errors detected, please try again.",
          icon: "error",
          buttonsStyling: false,
          confirmButtonText: "Ok, got it!",
          customClass: {
            confirmButton: "btn font-weight-bold btn-light-primary",
          },
        });
      });
  };
  // Public Functions
  return {
    init: function () {
      SubmitSiwesForm();
    },
  };
})();

// Class Initialization
jQuery(document).ready(function () {
  KTLogin.init();
});
