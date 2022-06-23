<div class="footer-bg">
    <!-- Contact us -->
  
    <!-- End Contact us -->

    <!-- Footer -->
    <section class="footer-section">
        <div class="right-flowo">
            <img src="{{ asset('FrontEnd/img/group_footer.png') }}" width="200px" height="200px" alt="">
        </div>

        <footer class="footer pb-5">
            <div class="container">
                <div class="row">
                    <div class="col-12 col-md-4 col-lg-4 mt-5">
                        <div class="footer_logo">
                            <img src="{{ asset('FrontEnd/img/logo.png') }}" alt="footer_logo">
                        </div>
                        <div class="footer-details">
                            <h4>AL Muaathir</h5>
                                <p>{{ $website_des->{app()->getLocale()} }}</p>
                        </div>
                        <div class="Social Media">
                            <h4>Social Media</h6>
                                <div class="social d-flex">
                                    <a href="#" class="me-2">
                                        <div class="icon-box d-flex justify-content-center align-items-center"><i class="fa-brands fa-facebook-f"></i></div>
                                    </a>
                                    <a href="#" class="me-2">
                                        <div class="icon-box d-flex justify-content-center align-items-center"><i class="fa-brands fa-youtube"></i></div>
                                    </a>
                                    <a href="#" class="me-2">
                                        <div class="icon-box d-flex justify-content-center align-items-center"><i class="fa-brands fa-twitter"></i></div>
                                    </a>
                                </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-4 col-lg-4 mt-5">
                        <div class="footer_links">
                            <h4>Quick Links</h4>
                            <ul class="quick_links">
                                <li><a href="about.html">About</a></li>
                                <li><a href="our-services.html">Services</a></li>
                                <li><a href="contact.html">Contact</a></li>
                                <li><a href="#">Faq</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-12 col-md-4 col-lg-4 mt-5">
                        <div class="footer_contact">
                            <h4>Contact Info</h4>
                            <ul class="contact_links">
                                <li><i class="fa-solid fa-location-dot fa-xl"></i><a>{{ $contact_info?->location }}</a></li>
                                <li><i class="fa-solid fa-phone fa-xl"></i><a href="tel:{{ $contact_info?->phone }}">{{ $contact_info?->phone }}</a></li>
                                <li><i class="fa-solid fa-envelope fa-xl"></i><a href="{{ $contact_info?->email }}">{{ $contact_info?->email }}</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
        </footer>
    </section>
    <!-- End Footer -->
</div>