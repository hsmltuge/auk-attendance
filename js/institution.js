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
  $("#institutiontype").change((e) => {
    switch ($(e.target).val()) {
      case "University":
        $(".institutiondetails").load("institutions/universities.php");
        $("#institutionname").sort_select_box();
        break;
      case "Polytechnic":
        $(".institutiondetails").load("institutions/polytecnics.php");
        $("#institutionname").sort_select_box();
        break;
      case "College of Education":
        $(".institutiondetails").load("institutions/colleges.php");
        $("#institutionname").sort_select_box();
        break;
      default:
        $(".institutiondetails").html(
          '<input class="form-control h-auto py-7 px-6 rounded-lg border-1" type="text" name="institutionname" autocomplete="off" placeholder="Institution Name"/>'
        );
        break;
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
        institutionname: {
          validators: {
            notEmpty: {
              message: "Institution name is required",
            },
          },
        },
        rank: {
          validators: {
            notEmpty: {
              message: "Rank is required",
            },
          },
        },
        designation: {
          validators: {
            notEmpty: {
              message: "Designation is required",
            },
          },
        },
        specialization: {
          validators: {
            notEmpty: {
              message: "Specialization address is required",
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
              institutionname: form.querySelector('[name="institutionname"]')
                .value,
              rank: form.querySelector('[name="rank"]').value,
              designation: form.querySelector('[name="designation"]').value,
              specialization: form.querySelector('[name="specialization"]')
                .value,
              institutionemail: form.querySelector('[name="institutionemail"]')
                .value,
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
                location.href = "research.php";
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
