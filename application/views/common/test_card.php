   <link rel="preconnect" href="https://fonts.googleapis.com">
   <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
   <link href="https://fonts.googleapis.com/css2?family=Almarai:wght@800&family=Anton&family=Roboto+Condensed:wght@300;400;700&display=swap" rel="stylesheet">

   <style>
       :root {
           --blue: #141348;
           --name-blue: #211F5D;
           --white: #ffffff;
       }

       .id_body {
           font-family: 'Roboto Condensed', sans-serif;
           line-height: 1.2;
           position: relative;
           color: #000;
           margin: 0 auto;
       }

       .id_body,
       .main_details {
           display: flex;
       }

       .id_body {
           width: 324px;
           height: 204px;
           border: 1px solid;
           background: url('../assets/images/svg.png') right;
       }

       .side_info {
           padding: 5px 5px 5px 20px;
           color: var(--blue);
           font-family: 'Anton', sans-serif;
       }


       .side_info h3 {
           position: absolute;
           /* top: 185px;
           left: 10px; */
           /* margin: 185px 0 0 -15px; */
           bottom: -30px;
           left: 5px;
           transform-origin: 0 0;
           transform: rotate(270deg);
           font-size: 22px;
           font-weight: 900;
       }

       .main_details {
           margin-top: 3%;
       }

       .photo_section {
           width: 25%;
           margin-right: 3%;
       }

       .company_details {
           margin: 4% 0% 0% 6%;
       }

       .photo {
           margin-bottom: 10px;
       }

       .photo img {
           width: 100%;
           border: 1px solid;
       }

       .signature {
           font-size: 8px;
           text-align: center;
           font-weight: bold;
       }

       p {
           margin: 0px;
       }

       .first_det,
       .mid_det,
       .last_det {
           font-size: 9.2px;
           font-weight: bold;
       }

       .details_card {
           font-size: 12px;
           font-weight: bold;
           width: 70%;
       }

       .vl {
           border-left: 2px solid var(--white);
           height: 184px;
           margin: 15px 0px 0px 10px;
       }

       .nealogo {
           position: absolute;
           /* left: 20px;
           top: 15px; */
           top: 5px;
           left: 10px;
       }

       .nealogo img {
           width: 40px;
       }

       .company_name {
           font-weight: bold;
           font-size: 22.8px;
       }

       .id_card_title,
       .id_card_name {
           font-weight: 800;
       }

       .id_card_name {
           color: var(--name-blue);
           font-size: 15px;
       }

       .id_card_title {
           font-family: 'Almarai', sans-serif;
           font-size: 17px;
       }

       .id_card_div {
           text-align: center;
           background-color: var(--blue);
           color: var(--white);
       }

       .id_card_category {
           font-size: 10px;
       }

       .border_top {
           border-top: 2px solid;
       }

       .qr_code {
           position: absolute;
           /* top: 150px;
           left: 280px; */
           bottom: 5px;
           right: 5px;
       }

       .qr_code img {
           width: 50px;
       }

       .only_sev {
           width: 77%;
       }

       .main-card {
           margin: 0 auto;
       }
   </style>

   <div class="row">
       <div class="col-md-3 col-sm-4 col-12">
           <label for="searchMember">Search Member</label>
            <input type="text" name="searchMember" id="searchMember" class="form-control">
       </div>
       <div class="col-md-3 col-sm-4 col-12">
           <!-- <label for="searchMember">Search Member</label> -->
            <button class="btn btn-primary mt-4">Search</button>
       </div>
   </div>

   <div class="main-card card mb-3 col-md-6 col-12 mt-3">
       <div class="card-body" style="overflow-y: auto;">
           <h5 class="card-title">Membership details</h5>

           <div class="id_body">
               <div class="side_info">
                   <h3>GENERAL MEMBER</h3>
                   <div class="vl"></div>
               </div>
               <div class="main_info">
                   <div class="nealogo">
                       <img src="<?= base_url('/assets/images/nea.png') ?>" alt="nea">
                   </div>
                   <div class="company_details">
                       <p class="company_name">Nepal Engineers' Association</p>
                       <p class="first_det">Head Office: Pulchowk, Lalitpur, Nepal, G.P.O. Box No.: 604, Kathmandu</p>
                       <p class="mid_det">Phone No.: 5010251/5010252, Fax: 977-1-5010253</p>
                       <p class="last_det">Email: info@neanepal.org.np, Web: www.neanepal.org.np</p>
                   </div>
                   <div class="main_details">
                       <div class="photo_section">
                           <div class="photo">
                               <img class="engineer_photo" src="<?= base_url('/assets/images/stockphoto.jpg') ?>" alt="stockphoto">
                           </div>
                           <div class="signature">
                               <div class="border_top"></div>
                               Approved by <br />
                               General Secretary
                           </div>
                       </div>
                       <div class="details_card">
                           <div class="id_card_div">
                               <p class="id_card_title">IDENTITY CARD</p>
                           </div>
                           <p class="id_card_name">Er. Akash Babu Patel</p>
                           <p class="id_card_category">Category: <span class="category_name">Electronics & Communication</span>
                           </p>
                           <p class="id_card_category">Membership No.: <span class="membership_no">35536</span></p>
                           <p class="id_card_category only_sev">Citizenship No.: <span class="citizen_no">341051/650</span></p>
                           <p class="id_card_category only_sev"><span class="address">Birgunj</span></p>
                           <p class="id_card_category only_sev">Issued Date: <span class="issued_date">22 March 2021</span></p>
                           <p class="id_card_category only_sev">Valid Till: <span class="valid_till">15 July 2021</span></p>
                       </div>

                       <div class="qr_code">
                           <img class="qr_code_image" src="<?= base_url('assets/images/qr.PNG') ?>" alt="">
                       </div>

                   </div>

               </div>
           </div>

       </div>
   </div>