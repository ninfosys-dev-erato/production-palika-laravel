<div style="width: 60%; margin: 0px auto; padding: 10px; border: 5px double red ;">


    <header class="header"
        style="display: flex; justify-content: space-between; align-items: center; padding: 10px 0; width: 100%; border-bottom: 2px solid black; text-align: center;">

        <!-- Logo Container (Left) -->
        <div class="logo-container" style="width: 100px; text-align: center;">
            <a href="{{ route('customer.home.index') }}" aria-label="Go to homepage">
                <img src="{{ asset('assets/img/avatars/Emblem_of_Nepal.svg.png') }}" alt="National Emblem of Nepal"
                    class="primary-logo" style="width: 80px; height: auto; display: block; margin: 0 auto;" />
            </a>
        </div>

        <!-- Text Container (Center) -->
        <div class="text-container" style="flex: 1; text-align: center;">
            <h3 style="margin: 0; font-size: 18px; font-weight: bold;">Lalitpur Nagarpalika</h3>
            <p style="margin: 2px 0; font-size: 14px;">Lalitpur Palika</p>
            <p style="margin: 2px 0; font-size: 14px;">Nagar Karyalako Karyala</p>
            <p style="margin: 2px 0; font-size: 14px;">Office of the Municipal Office</p>
            <p style="margin: 2px 0; font-size: 14px;">Lalitpur, Kathmandu, Nepal</p>
        </div>

        <!-- Logo Container (Right) -->
        <div class="logo-container" style="width: 100px; text-align: center;">
            <a href="{{ route('customer.home.index') }}" aria-label="Go to homepage">
                <img src="{{ asset('assets/img/avatars/Emblem_of_Nepal.svg.png') }}" alt="National Emblem of Nepal"
                    class="primary-logo" style="width: 80px; height: auto; display: block; margin: 0 auto;" />
            </a>
        </div>

    </header>

    <div style="
    position: relative; 
    background: transparent;
    z-index: 1;
">
        <!-- Add this pseudo-element for background -->
        <div
            style="
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%); 
        width: 50%;
        height: 50%;
        background-image: url('{{ asset('assets/img/avatars/Emblem_of_Nepal.svg.png') }}');
        background-repeat: no-repeat;
        background-position: center center;
        background-size: contain;
        opacity: 0.2;
        z-index: -1;
    ">
        </div>
        <div style="margin-bottom: 20px; ">
            <h2 style="text-align: center; color: red;">सेवा / फारम / संस्था / व्यवसाय दर्ता प्रमाणपत्र</h2>
        </div>

        <div style="position: relative; margin-bottom: 20px; line-height: 2.2;">
            <!-- Left Content -->
            <div>
                <p style="margin: 0;">आजको मिति: 2081/11/14</p>
                <p style="margin: 0;">दर्ता मिति: 2081/11/14</p>
                <p style="margin: 0;">प्रमाणपत्र नं: १३</p>
            </div>

            <!-- Square Box -->
            <div style="position: absolute; top: 0; right: 0; width: 90px; height: 90px; border: 2px solid black;">
            </div>
        </div>

        <div style="margin-bottom: 20px;">
            <p style="text-align: justify;">
                Lorem ipsum, dolor sit amet consectetur adipisicing elit. Ad doloremque fuga corporis quam voluptate sed
                reprehenderit, facere cumque quae neque minus reiciendis ullam repudiandae, at mollitia, dicta eligendi
                iste
                labore!
                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Excepturi nam nostrum dignissimos culpa
                temporibus
                repellendus minus, ratione nesciunt dolores quam saepe autem cumque non labore! Eum, tempore!
                Blanditiis,
                quod
                cum.
            </p>
        </div>

        <div style="position: relative; margin-bottom: 20px; line-height: 2.2; width: 100%;">
            <!-- Left Content -->
            <div>
                <p style="margin: 0;">व्यवसायको नाम: ninja infosys</p>
                <p style="margin: 0;">व्यवसायको रहने स्थान: अनामनगर</p>
                <p style="margin: 0;">व्यवसायको किसिम: टेक्नोलोजी</p>
                <p style="margin: 0;">व्यवसाय सञ्चालन गर्ने मूल्य वस्तु, सेवा तथा कामको विवरण: टेक</p>
                <p style="margin: 0;">पूँजी लगानी: १००००००</p>
                <p style="margin: 0;">मालिक / प्रोपराइटरको नाम, ठेगाना: रमेश श्रेष्ठ</p>
                <p style="margin: 0;">न.प्र.न.: १२३</p>
                <p style="margin: 0;">ठेगाना: अनामनगर</p>
                <p style="margin: 0;">सम्पर्क नं: २३४३२</p>
                <p style="margin: 0;">घर/जग्गाको नाम, ठेगाना: something something</p>
                <p style="margin: 0;">ठेगाना: अनामनगर</p>
            </div>

            <!-- Rectangular Box -->
            <div
                style="position: absolute; top: 50%; right: 0; width: 50%; height: 40%; padding: 3px; border: 1px solid black;  box-sizing: border-box; transform: translateY(-30%);">
                <p style="font-weight: bold; margin: 0px;">अन्य निकायमा दर्ता भएको विवरण</p>
                <p style="margin: 0px;">दर्ता नं: ५६७८</p>
            </div>
        </div>

        <div style="display: flex; justify-content: space-around; margin-top: 30px;">
            <div style="margin: 5px; text-align: center;">
                <p style="margin: 0;">.....................</p>
                <p style="margin: 0;">नाम</p>
                <p style="margin: 0;">पद</p>
            </div>
            <div style="margin: 5px; text-align: center;">
                <p style="margin: 0;">.....................</p>
                <p style="margin: 0;">नाम</p>
                <p style="margin: 0;">पद</p>
            </div>
            <div style="margin: 5px; text-align: center;">
                <p style="margin: 0;">.....................</p>
                <p style="margin: 0;">नाम</p>
                <p style="margin: 0;">पद</p>
            </div>
        </div>

        <div>
            <p>१. व्यवसायले प्रत्येक आर्थिक वर्षको लागि तोकिएको व्यवसाय कर उक्त आ. ब. को असार मसान्तभित्र बुझाई
                प्रमाणपत्र नवीकरण गर्नुपर्नेछ।</p>
            <p>2. नगरपालिका कर, शुल्क, दस्तुर समयमा नबुझाइमा करदातालाई नगरपालिका तथा वडा कार्यालयबाट दिइने सेवा, सुविधा
                र
                सिफारिस रोक्का गरिने छ।</p>
            <p>3. यो प्रमाणपत्र व्यवसाय गरेको स्थानमा सबैले देख्ने गरी राख्नु पर्नेछ।</p>
        </div>

        <table border="1" cellpadding="10" cellspacing="0" style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr>
                    <th>आर्थिक वर्ष</th>
                    <th>नवीकरण गरेको मिति</th>
                    <th>म्याद पुग्ने मिति</th>
                    <th>कर तथा जरिवाना तिरेको रकम</th>
                    <th>रसिद नं.</th>
                    <th>नवीकरण गर्नेको दरखास्त</th>
                    <th>काउफियत</th>
                </tr>
            </thead>
            <tbody>
                <tr style="height: 30px">
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="height: 30px">
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="height: 30px">
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="height: 30px">
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="height: 30px">
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="height: 30px">
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="height: 30px">
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="height: 30px">
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            </tbody>
        </table>

        <div style="margin:10px 0px; text-align: center; font-size: 14px; border-top: 2px solid black;">
            <p style="display: inline-block; margin: 5px 10px;">कार्यालय कोड नं: 019128912</p>
            <p style="display: inline-block; margin: 5px 10px;">स्थायी लेखा नं: 2109218</p>
            <p style="display: inline-block; margin: 5px 10px;">सम्पर्क नं: 7189821</p>
            <div>


                <p style="display: inline-block; margin: 5px 10px;">इमेल: something@gov.np</p>
                <p style="display: inline-block; margin: 5px 10px;">फेसबुक: facebook.com</p>
            </div>
            <p style="margin: 5px 10px;">वेबसाइट: nepal.com.np</p>
        </div>

    </div>
</div>
