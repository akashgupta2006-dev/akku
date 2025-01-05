<?php include('header.php');?>


    <!--==============================
    Breadcumb
============================== -->
    <div class="breadcumb-wrapper " data-bg-src="assets/img/service/contact.jpg" data-overlay="theme">
        <div class="container">
            <div class="breadcumb-content">
                <h1 class="breadcumb-title">Contact us</h1>
                <ul class="breadcumb-menu">
                    <li><a href="index.php">Home</a></li>
                    <li>Contact us</li>
                </ul>
            </div>
        </div>
    </div>
    <!--===================== Contact Area  =========================-->
    <div class="space overflow-hidden contact-area-1 position-relative z-index-common">
      <div class="container">
        <div class="contact-wrap1">
          <div class="row gx-60 gy-40">
            <div class="col-xl-4 col-lg-5">
                <div class="contact-feature">
                    <div class="box-icon">
                        <i class="fas fa-map-location-dot"></i>
                    </div>
                    <div class="media-body">
                        <h3 class="box-title">Address</h3>
                        <p class="box-text">
                           H.No- 379,Near Geeta Mandir, Sector 16A, Faridabad-121002
                        </p>
                    </div>
                </div>
                <div class="contact-feature">
                    <div class="box-icon" data-theme-color="#FFAC00">
                        <i class="fas fa-phone-volume"></i>
                    </div>
                    <div class="media-body">
                        <h3 class="box-title">Phone</h3>
                        <p class="box-text"><a href="tel:0129 3698273">0129 3698273</a></p>
                        <p class="box-text"><a href="tel:+919958892266">9958892266</a></p>
                    </div>
                </div>
                <div class="contact-feature">
                    <div class="box-icon" data-theme-color="#122F2A">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <div class="media-body">
                        <h3 class="box-title">Email</h3>
                        <p class="box-text"><a href="mailto:info@donet.com">info@nirogyamcspeldercare.com</a></p>
                    </div>
                </div>
                <div class="contact-feature" data-theme-color="#FF5528">
                    <div class="box-icon">
                        <i class="fas fa-comment-question"></i>
                    </div>
                    <div class="media-body">
                        <h3 class="box-title">Have Questions?</h3>
                        <p class="box-text">Discover more by visiting us or joining our community</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-8 col-lg-7">
                <div class="contact-map">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d14037.181563119055!2d77.3166897!3d28.4103424!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x390cddbb8cec793d%3A0x6a0d68209f748d06!2sNirogyam%20CSP%20Elder%20Care%20Foundation!5e0!3m2!1sen!2sin!4v1733481950425!5m2!1sen!2sin" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>
          </div>
        </div>
        <div class="contact-page-form-wrap space-top">
          <div class="row gy-40">
            <div class="col-xl-6 align-self-end">
                <div class="contact-thumb1-1">
                    <img src="assets/img/normal/contact_1_1.png" alt="img">
                </div>
            </div>
            <div class="col-xl-6">
              <!--================ Contact Area  =====================-->
              <div class="contact-form-v1 contact-page-form">
                <form id="contact_form" class="contact-form style-border " onsubmit="return false;" >
                  <div class="row">
                    <div class="form-group style-border col-12">
                        <input type="text" class="form-control" name="name" id="name" placeholder="Your Name*">
                    </div>
                    <div class="form-group style-border col-12">
                        <input type="email" class="form-control" name="email" id="email" placeholder="Email Address">
                    </div>
                    <div class="form-group style-border col-12">
                        <input type="text" maxlength="10" class="form-control" name="phone" id="phone" onkeyup="allowOnlyContactNumbers(this)" placeholder="Phone Number*">
                    </div>
                    <div class="form-group style-border col-12">
                        <textarea name="message" id="message" cols="30" rows="3" class="form-control" placeholder="Type Your Message"></textarea>
                    </div>
                    <div class="form-btn col-12">
                        <button class="th-btn" onclick="AddContact()" >Send a Message</button>
                    </div>
                  </div>
                  <p class="form-messages mb-0 mt-3"></p>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="orderModal" tabindex="-1" aria-labelledby="
     exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="row justify-content-center">
            <div class="col-lg-4 col-10 bg-light">
              <div class="modal-content">
                <div class="modal-header">
                  <h6 class="modal-title" id="exampleModalLabel">Enquiry Now</h6>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">x</button>
                </div>
                <div class="modal-body p-3">
                    <div class="login-wrapper">
                      <div class="login-content">
                        <form id="order_form" onsubmit="return false;">
                          <div class="row g-2">
                            <div class="col-md-12">
                              <div class="form-inner">
                                <label> Name<span class="text-danger">*</span></label>
                                <input type="text" name="name" id="order_name" class="form-control" placeholder="...">
                              </div>
                            </div>
                          
                            <div class="col-md-12">
                              <div class="form-inner">
                                <label> Phone <span class="text-danger">*</span></label>
                                <input type="text" onkeyup="allowOnlyContactNumbers(this)" name="phone" maxlength="10" id="order_phone" class="form-control" placeholder="...">
                              </div>
                            </div>

                            <div class="col-md-12">
                              <div class="form-inner">
                                <label> Notes </label>
                                <textarea name="message"  class="form-control"> </textarea>
                              </div>
                            </div>
                       
                            <div class="col-md-12">
                              <div class="form-inner">
                                <input type="hidden" name="product_id" id="product_id_enq" class="form-control" >
                                <button class="btn btn-primary mt-2" onclick="AddEnquiry()" type="submit">Enquiry Now</button>
                              </div>
                            </div>
                          </div>
                        </form>
                      </div>
                    </div>
                </div>
              </div>
            </div>
        </div>
      </div>
    </div>
    <!--==============================
	Footer Area
==============================-->
<script type="text/javascript">
    function ValidateEmail(email)
    {
      var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
      if(email.match(mailformat)) {
        return true;
      } else {
        alertify.alert("You have entered an invalid email address!");
        // document.form1.text1.focus();
        return false;
      }
    }

    function allowOnlyContactNumbers(inputElement) {
        var inputValue = inputElement.value.replace(/[^0-9]/g, '');
        inputElement.value = inputValue;
    }

    function EnquiryNow(ID) {
        // var name = response.data.PackageName;
        $("#product_id_enq").val(ID);
        $("#orderModal").modal('show');
    }

    function AddContact() {
        var first_name = document.getElementById('name').value;
        if (first_name=='') {
            alertify.alert('Name is required!');
            return false;
        }

        var phone = document.getElementById('phone').value;
        if (phone=='') {
            alertify.alert('Phone is required!');
            return false;
        }

        var address_email = document.getElementById('email').value;
        if (address_email!='') {
            if (ValidateEmail(address_email)==false) {
               return false;
            }
        }

        let myForm = document.getElementById("contact_form");
        var formData = new FormData(myForm);
        $.ajax({
          url: "add_contact_action.php",
          type: "POST",
          data: formData,
          async: false,
          success: function(data) {
            var response = JSON.parse(data);
            alertify.alert(response.message);
            if (response.error == false)
            {
              setInterval(function(){
                location.reload();
              }, 2000);
            }
          },
          cache: false,
          contentType: false,
          processData: false,
        });
        return false;
    }
</script>
    <?php include('footer.php');?>