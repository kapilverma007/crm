<!doctype html>
<html>
    <head>
        <meta charset="UTF-8" />
        <title>Contract</title>

        <style>
            @page {
                size: A4;
                margin: 10px 20px;
            }
            body {
                font-family: Arial, Helvetica, sans-serif;
                margin: 0;
                padding: 0;
                color: #000;
                line-height: 135%;
                font-size: 12px;
                font-weight: 400;
                font-style: normal;
            }

            .page {
                page-break-before: always;
                position: relative;
                padding: 5px 0;
            }

            .page:first-of-type {
                page-break-before: auto;
            }

            h3 { margin: 6px 0 4px 0; font-size: 13px; }
            h4 { margin: 5px 0 2px 0; font-size: 11.5px; }
            p { margin: 3px 0; }
            li { margin-bottom: 1px; }
            ul { margin-top: 3px; margin-bottom: 3px; }

            .header {
                text-align: center;
            }

            .header-with-border {
                text-align: center;
                border-bottom: 3px solid #45a4db;
                margin-bottom: 8px;
                padding-bottom: 3px;
            }

            .header-with-border img,
            .header img {
                max-width: 250px;
            }

            ul {
                padding-left: 16px;
                list-style-type: disc;
            }

            .footer-right {
                text-align: right;
                margin-top: 10px;
            }

            .footer-right img {
                max-height: 50px;
            }

        </style>
    </head>

    <body style="background-image: url('{{ $bgImg }}'); background-size: 100% 100%; background-repeat: no-repeat; -webkit-print-color-adjust: exact; print-color-adjust: exact;">
        <!-- Page 1 -->
        <div class="page">
            <!-- Header Logo Area -->
            <div class="header" style="margin-top: 10px">
                <img src="{{ $logo }}" alt="Falcon International Consultants" />
                <h2 style="color: #5b8cc9; font-weight: 500; margin-top: 20px">Contract of Engagement</h2>
            </div>

            <!-- Customer Details -->
            <div style="margin-top: 40px">
                <p style="margin: 0 0 6px 0; font-weight: 600">Customer Name: {{ $full_name }}</p>
                <p style="margin: 0 0 6px 0; font-weight: 600">Contract No: {{ $contract_no }}</p>
                <p style="margin: 0 0 6px 0; font-weight: 600">Service: {{ $service }}</p>
                <p style="margin: 0 0 6px 0; font-weight: 600">Country: {{ $city }}</p>
            </div>

            <!-- Footer Company Info -->
            <div style="text-align: center; margin-top: 100px;">
                <p style="margin: 0 0 10px 0; font-weight: 600">Falcon International Consultants</p>
                <p style="margin: 0 0 10px 0; font-weight: 600">
                    607, 6th Floor, Al Rossais Commercial Center, Olaya, Riyadh, KSA
                </p>
                <p style="margin: 0 0 6px 0; font-weight: 600">Contact No.: +966 54 6130 122</p>
            </div>
        </div>

        <!-- Page 2 -->
        <div class="page">
            <!-- Header -->
            <div class="header-with-border">
                <img src="{{ $logo }}" />
            </div>

            <!-- Company Info -->
            <div>
                <p style="margin: 0 0 6px 0; font-weight: 600">Falcon International Consultants</p>
                <p style="margin: 0 0 6px 0;">Email: info@falconinternationalconsultants.com</p>
                <p style="margin: 0 0 6px 0">Website: http://www.falconinternationalconsultants.com</p>
            </div>

            <!-- Client Details -->
            <div style="margin-top: 15px">
                <h3>Client Details</h3>
                <p style="margin: 0 0 6px 0">Name: {{ $full_name }}</p>
                <p style="margin: 0 0 6px 0">Address: {{ $address }}</p>
                <p style="margin: 0 0 6px 0">Contact No.: {{ $phone_number }}</p>
                <p style="margin: 0 0 6px 0">E-Mail: {{ $email }}</p>
            </div>

            <!-- Agreement Intro -->
            <div style="margin-top: 15px">
                <h3>Service Retainer Agreement</h3>
                <p>
                    This Service Retainer Agreement ("Agreement") is made between Falcon International Consultants
                    (hereinafter referred to as the "Company"), with its headquarters at Office 607, 6th Floor, Al
                    Rossais Commercial Center, Olaya, Riyadh, KSA and a branch office at Alqamah Al Hadrami, Al Zahra,
                    Jeddah, Saudi Arabia and the undersigned client (hereinafter referred to as the "Client"). This
                    contract remains in effect for 12 months from the date of signing.
                </p>

                <p><strong>Purpose:</strong></p>

                <p>
                    <strong>Service Fee:</strong><br />
                    The above service fee will remain unchanged unless the Client opts for additional services.
                    Government taxes apply as per applicable laws.
                </p>
            </div>

            <!-- Terms -->
            <div style="margin-top: 10px">
                <h3>Terms and Conditions</h3>

                <h4>1. Services Provided:</h4>

                <ul>
                    <li>
                        The Company will guide the Client through the work permit application process, including
                        timelines, procedures, and associated costs.
                    </li>
                    <li>The Company will provide an up-to-date checklist of required documents.</li>
                </ul>
            </div>

            <!-- Footer -->
            <div class="footer-right">
                <img src="{{ $scanner }}" alt="scanner" />
            </div>
        </div>

        <!-- Page 3 -->
        <div class="page">
            <!-- Header -->
            <div class="header-with-border">
                <img src="{{ $logo }}" />
            </div>

            <ul>
                <li>A dedicated Case Manager will be assigned to the Client to assist throughout the process.</li>
                <li>
                    The Company will assist in completing all relevant forms for visa, application, and assessment
                    processes.
                </li>
                <li>
                    If desired, the Company may act as the Client's representative with the necessary authorization.
                </li>
                <li>
                    Assistance will be provided for the assessment of the Client's professional and career competencies,
                    including guidance on documentation.
                </li>
                <li>
                    The Company will provide sample formats for past applications to help the Client meet assessment and
                    application requirements.
                </li>
                <li>Regular updates on the status of the application will be provided via phone or email.</li>
                <li>Assistance will be provided in booking visa appointments and preparing required cover letters.</li>
                <li>Guidance will be provided for medical examinations and obtaining police clearance certificates.</li>
            </ul>

            <!-- Terms Continued -->
            <div style="margin-top: 10px">
                <h4>2. Administrative Review:</h4>
                <p>
                    If the application is overlooked or mishandled, the Company will file an administrative review and
                    lodge complaints at no additional cost, except for third-party charges (e.g., government fees or
                    legal services).
                </p>

                <h4>3. Additional Services:</h4>
                <p>The Company may assist with foreign exchange and air ticketing based on availability.</p>

                <h4>4. Responsibilities and Limitations:</h4>
                <ul>
                    <li>
                        The Company will provide general guidance regarding living conditions in the destination
                        country. However, the Company is not responsible for document procurement or other tasks that
                        fall under the Client's responsibility.
                    </li>
                    <li>
                        The Company is not liable for refunds of any fees paid to immigration authorities, embassies, or
                        consulates if the visa application is rejected.
                    </li>
                    <li>
                        The registration and processing fees cover the Company's services only and do not include any
                        third-party application or assessment fees.
                    </li>
                    <li>
                        The Company reserves the right to terminate its services if the Client fails to comply with the
                        terms of this Agreement.
                    </li>
                </ul>

                <h4>5. Refund Policy:</h4>
                <ul>
                    <li>
                        No refund will be made if the visa is rejected for reasons such as failing to attend the
                        interview, submitting false documents, or failing to meet consular requirements.
                    </li>
                    <li>
                        A refund of up to 100% of the Company's service fee may be granted in cases where the work
                        permit is denied due to an error or misrepresentation by the Company, or if immigration rules
                        change within 30 days of signing this Agreement, rendering the Client ineligible under the new
                        rules.
                    </li>
                    <li>
                        If immigration rules change after 30 days of signing the agreement, a refund may be issued minus
                        VAT and processing fees. Alternatively, the client may choose to apply for another country, with
                        costs adjusted based on the selected country.
                    </li>
                </ul>
            </div>

            <!-- Footer -->
            <div class="footer-right">
                <img src="{{ $scanner }}" alt="scanner" />
            </div>
        </div>

        <!-- Page 4 -->
        <div class="page">
            <!-- Header -->
            <div class="header-with-border">
                <img src="{{ $logo }}" />
            </div>

            <!-- Terms Continued -->
            <div style="margin-top: 10px">
                <h4>6. Responsibilities of the Client:</h4>
                <ul>
                    <li>
                        The Client is responsible for providing accurate and complete information, including past visa
                        rejections, and ensuring the authenticity of all documents.
                    </li>
                    <li>The Client must submit all required documents in a timely manner.</li>
                    <li>
                        The Company is not liable for any consequences arising from the Client providing false or
                        fabricated information.
                    </li>
                </ul>

                <h4>7. Confidentiality of Documents:</h4>
                <p>
                    All documents submitted to the Company will not be returned. The Client must only provide scanned
                    copies of original documents.
                </p>

                <h4>8. Communication and Deadlines:</h4>
                <ul>
                    <li>The Company will communicate with the Client regularly to provide updates.</li>
                    <li>
                        No specific deadlines will be entertained by the Client, as the process requires thorough
                        attention and may vary based on individual cases.
                    </li>
                </ul>

                <h4>9. Payment Terms:</h4>
                <ul>
                    <li>Payments are due within 7 days of the invoice date.</li>
                    <li>If a payment is dishonored, the Company reserves the right to take legal action.</li>
                </ul>

                <h4>10. Liability Disclaimer:</h4>
                <ul>
                    <li>
                        The Company does not guarantee visa approval and is not responsible for any travel arrangements
                        made before official confirmation of visa approval.
                    </li>
                    <li>
                        The Company is not responsible for any changes in government regulations or processes that may
                        occur during the application process.
                    </li>
                </ul>

                <h4>11. Termination:</h4>
                <p>
                    The Company reserves the right to terminate this Agreement if the Client fails to adhere to the
                    terms outlined, including non-payment, failure to submit required documents, or any attempt to harm
                    the Company's reputation.
                </p>

                <h4>12. Defamation and Unfair Feedback Clause</h4>
                <p>
                    The Client agrees that any public statement, review, or feedback provided about Falcon International
                    Consultants and its services must be truthful and based on actual experiences. Any false,
                    misleading, defamatory, or unjust statements made by the Client, whether verbal, written, or posted
                    online, that negatively affect the reputation of Falcon International Consultants will be considered
                    a breach of this agreement.
                </p>
            </div>

            <!-- Footer -->
            <div class="footer-right">
                <img src="{{ $scanner }}" alt="scanner" />
            </div>
        </div>

        <!-- Page 5 -->
        <div class="page">
            <!-- Header -->
            <div class="header-with-border">
                <img src="{{ $logo }}" />
            </div>

            <!-- Terms Continued -->
            <div style="margin-top: 10px">
                <p>
                    In the event of such a breach, Falcon International Consultants reserves the right to pursue legal
                    action for damages, including but not limited to reputational harm, loss of business, or any other
                    associated costs. Furthermore, Falcon International Consultants may terminate any ongoing services
                    or contracts with the Client without prior notice.
                </p>

                <h4>Refund Clause:</h4>

                <p><strong>1. The Company has the right to terminate services without refund if the Client:</strong></p>

                <ul>
                    <li>Fails to submit documents within 30 days of registration.</li>
                    <li>Corresponds directly with a government body without the Company's authorization.</li>
                    <li>Fails to respond to communication from the Company within 30 days.</li>
                    <li>Voluntarily withdraws from the process.</li>
                    <li>
                        Fails to clear required exams, provide medical clearance, or submit a valid Police Clearance
                        Certificate.
                    </li>
                    <li>Fails to prove sufficient funds for the visa application.</li>
                </ul>

                <h4 style="margin-top: 10px; margin-bottom: 10px">Payment Details:</h4>

                <p style="margin: 0">Total Contract Amount: {{ $Contract_Amount }}</p>
                <p style="margin: 0">Registration: {{ $Registration }}</p>
                <p style="margin: 0">On receiving Job Offer Letter: {{ $On_Receiving_job_Offer_Letter_Amount }}</p>
                <p style="margin: 0">On receiving Work Permit: {{ $On_Receiving_Work_Permit_Amount }}</p>
                <p style="margin: 0">On receiving Embassy Appointment: {{ $On_Receiving_Embassy_Appointment }}</p>
                <p style="margin: 0">After Visa Amount: {{ $After_Visa_Amount }}</p>
                <p style="margin: 0">Flight Ticket: {{ $Flight_Ticket }}</p>
                <p style="margin: 0">
                    By signing below, both parties agree to the terms and conditions outlined in this Agreement.
                </p>
            </div>

            <!-- Signature Area -->
            <div style="margin-top: 30px">
                <div>
                    <p style="margin: 0 0 6px; font-weight: 600">Client Signature: _____________________</p>
                    <p style="margin: 0 0 6px; font-weight: 600">Date: {{ $date }}</p>

                    <p style="margin: 0 0 6px; font-weight: 600">
                        Company Representative Signature: _____________________
                    </p>
                    <p style="margin: 0 0 6px; font-weight: 600">Date: {{ $date }}</p>
                </div>
            </div>

            <!-- Footer -->
            <div class="footer-right">
                <img src="{{ $scanner }}" alt="scanner" />
            </div>
        </div>

        <!-- Page 6 - Urdu Translation -->
        <div class="page" style="font-family: 'Noto Naskh Arabic', sans-serif; font-size: 14px;">
            <!-- Header -->
            <div class="header-with-border" style="text-align: center;">
                <img src="{{ $logo }}" />
            </div>

            <!-- Agreement Intro -->
            <div style="margin-top: 15px">
                <h3>سروس ریٹینر کا معاہدہ</h3>
                <p>
                    یہ سروس ریٹینر معاہدہ ("معاہدہ") فالکن انٹرنیشنل کنسلٹنٹس (جسے آئندہ "کمپنی" کہا جائے گا) اور دستخط شدہ کلائنٹ (جسے آئندہ "کلائنٹ" کہا جائے گا) کے درمیان طے پایا گیا ہے۔ کمپنی کا ہیڈ کوارٹر آفس 607، چھٹی منزل، ال روسائس کامرشل سینٹر، اولایا، ریاض، KSA میں واقع ہے اور برانچ آفس القمہ الحضرمی، الزہرہ، جدہ، سعودی عرب میں ہے۔ یہ معاہدہ دستخط کی تاریخ سے 12 ماہ تک مؤثر رہے گا۔
                </p>

                <p><strong>مقصد:</strong></p>

                <p>
                    <strong>سروس فیس:</strong><br />
                    مذکورہ بالا سروس فیس اس وقت تک تبدیل نہیں ہوگی جب تک کلائنٹ اضافی خدمات کا انتخاب نہ کرے۔
                    سرکاری ٹیکسز قابلِ اطلاق قوانین کے مطابق لاگو ہوں گے۔
                </p>
            </div>

            <!-- Terms -->
            <div style="margin-top: 10px">
                <h3>شرائط و ضوابط</h3>

                <h4>۱۔ فراہم کردہ خدمات:</h4>

                <ul>
                    <li>
                        کمپنی ورک پرمٹ درخواست کے عمل میں کلائنٹ کی رہنمائی کرے گی، بشمول وقتِ کار، طریقہ کار اور متعلقہ اخراجات۔
                    </li>
                    <li>کمپنی مطلوبہ دستاویزات کی تازہ چیک لسٹ فراہم کرے گی۔</li>
                    <li>کلائنٹ کی مدد کے لیے پورے عمل میں ایک مخصوص کیس مینیجر مقرر کیا جائے گا۔</li>
                    <li>
                        کمپنی ویزا، درخواست اور تشخیص کے عمل کے لیے تمام متعلقہ فارم مکمل کرنے میں مدد کرے گی۔
                    </li>
                    <li>
                        اگر مطلوب ہو تو کمپنی ضروری اجازت کے ساتھ کلائنٹ کے نمائندے کے طور پر کام کر سکتی ہے۔
                    </li>
                    <li>
                        کلائنٹ کی پیشہ ورانہ اور کیریئر کی قابلیت کے تعین کے لیے مدد فراہم کی جائے گی،
                        دستاویزات پر رہنمائی سمیت۔
                    </li>
                    <li>
                        کمپنی کلائنٹ کو تشخیص اور درخواست کی ضروریات پوری کرنے میں مدد کے لیے پچھلی درخواستوں کے نمونے فارمیٹ فراہم کرے گی۔
                    </li>
                    <li>درخواست کی صورتحال کی باقاعدہ اپڈیٹس فون یا ای میل کے ذریعے فراہم کی جائیں گی۔</li>
                    <li>ویزا اپائنٹمنٹ بک کرنے اور مطلوبہ کور لیٹرز تیار کرنے میں مدد فراہم کی جائے گی۔</li>
                    <li>طبی معائنے اور پولیس کلیئرنس سرٹیفکیٹ حاصل کرنے کے لیے رہنمائی فراہم کی جائے گی۔</li>
                </ul>
            </div>

            <!-- Footer -->
            <div class="footer-right">
                <img src="{{ $scanner }}" alt="scanner" />
            </div>
        </div>

        <!-- Page 7 - Urdu Translation Continued -->
        <div class="page" style="font-family: 'Noto Naskh Arabic', sans-serif; font-size: 14px;">
            <!-- Header -->
            <div class="header-with-border" style="text-align: center;">
                <img src="{{ $logo }}" />
            </div>

            <!-- Terms Continued -->
            <div style="margin-top: 10px">
                <h4>۲۔ انتظامی جائزہ:</h4>
                <p>
                    اگر درخواست نظرانداز کی گئی یا غلط طریقے سے سنبھالی گئی تو کمپنی بغیر اضافی لاگت کے انتظامی جائزہ دائر کرے گی اور شکایات درج کرے گی، سوائے تھرڈ پارٹی اخراجات (مثلاً سرکاری فیسیں یا قانونی خدمات) کے۔
                </p>

                <h4>۳۔ اضافی خدمات:</h4>
                <p>کمپنی دستیابی کی بنیاد پر زرمبادلہ اور ہوائی ٹکٹنگ میں مدد کر سکتی ہے۔</p>

                <h4>۴۔ ذمہ داریاں اور حدود:</h4>
                <ul>
                    <li>
                        کمپنی منزلِ مقصود ملک میں رہنے کے حالات کے بارے میں عمومی رہنمائی فراہم کرے گی۔ تاہم، کمپنی دستاویزات کی فراہمی یا دیگر کاموں کے لیے ذمہ دار نہیں جو کلائنٹ کی ذمہ داری میں آتے ہیں۔
                    </li>
                    <li>
                        اگر ویزا درخواست مسترد ہو جائے تو کمپنی امیگریشن حکام، سفارت خانوں یا قونصل خانوں کو ادا کی گئی کسی بھی فیس کی واپسی کے لیے ذمہ دار نہیں۔
                    </li>
                    <li>
                        رجسٹریشن اور پروسیسنگ فیسیں صرف کمپنی کی خدمات کو شامل کرتی ہیں اور ان میں کوئی بھی تھرڈ پارٹی درخواست یا تشخیص فیسیں شامل نہیں ہیں۔
                    </li>
                    <li>
                        اگر کلائنٹ اس معاہدے کی شرائط پر عمل کرنے میں ناکام رہے تو کمپنی اپنی خدمات ختم کرنے کا حق محفوظ رکھتی ہے۔
                    </li>
                </ul>

                <h4>۵۔ واپسی کی پالیسی:</h4>
                <ul>
                    <li>
                        اگر ویزا انٹرویو میں شرکت نہ کرنے، جھوٹی دستاویزات جمع کرنے، یا قونصلر تقاضے پورے نہ کرنے کی وجوہات سے مسترد ہو جائے تو کوئی رقم واپس نہیں کی جائے گی۔
                    </li>
                    <li>
                        کمپنی کی سروس فیس کا 100% تک واپس کیا جا سکتا ہے اگر ورک پرمٹ کمپنی کی غلطی یا غلط بیانی کی وجہ سے مسترد ہو، یا اگر اس معاہدے پر دستخط کے 30 دنوں کے اندر امیگریشن قوانین تبدیل ہو جائیں جس سے کلائنٹ نئے قوانین کے تحت نااہل ہو جائے۔
                    </li>
                    <li>
                        اگر معاہدے پر دستخط کے 30 دن بعد امیگریشن قوانین تبدیل ہوں تو VAT اور پروسیسنگ فیسوں کو منہا کر کے رقم واپس کی جا سکتی ہے۔ متبادل طور پر، کلائنٹ کسی دوسرے ملک کے لیے درخواست دینے کا انتخاب کر سکتا ہے، جس میں منتخب ملک کی بنیاد پر اخراجات ایڈجسٹ کیے جائیں گے۔
                    </li>
                </ul>
            </div>

            <!-- Footer -->
            <div class="footer-right">
                <img src="{{ $scanner }}" alt="scanner" />
            </div>
        </div>

        <!-- Page 8 - Urdu Translation Continued -->
        <div class="page" style="font-family: 'Noto Naskh Arabic', sans-serif; font-size: 14px;">
            <!-- Header -->
            <div class="header-with-border" style="text-align: center;">
                <img src="{{ $logo }}" />
            </div>

            <!-- Terms Continued -->
            <div style="margin-top: 10px">
                <h4>۶۔ کلائنٹ کی ذمہ داریاں:</h4>
                <ul>
                    <li>
                        کلائنٹ درست اور مکمل معلومات فراہم کرنے کا ذمہ دار ہے، بشمول ماضی کی ویزا رد ہونے کی معلومات، اور تمام دستاویزات کی صداقت کو یقینی بنانا۔
                    </li>
                    <li>کلائنٹ کو تمام مطلوبہ دستاویزات بروقت جمع کرنی ہوں گی۔</li>
                    <li>
                        کلائنٹ کی طرف سے جھوٹی یا جعلی معلومات فراہم کرنے سے پیدا ہونے والے کسی بھی نتیجے کے لیے کمپنی ذمہ دار نہیں۔
                    </li>
                </ul>

                <h4>۷۔ دستاویزات کی رازداری:</h4>
                <p>
                    کمپنی کو جمع کرائی گئی تمام دستاویزات واپس نہیں کی جائیں گی۔ کلائنٹ کو صرف اصل دستاویزات کی اسکین شدہ کاپیاں فراہم کرنی چاہئیں۔
                </p>

                <h4>۸۔ مواصلت اور آخری مہلتیں:</h4>
                <ul>
                    <li>کمپنی اپڈیٹس فراہم کرنے کے لیے کلائنٹ سے باقاعدگی سے رابطہ کرے گی۔</li>
                    <li>
                        کلائنٹ کی طرف سے کوئی مخصوص آخری مہلت قابل قبول نہیں ہوگی، کیونکہ اس عمل میں مکمل توجہ کی ضرورت ہوتی ہے اور یہ انفرادی معاملات کی بنیاد پر مختلف ہو سکتا ہے۔
                    </li>
                </ul>

                <h4>۹۔ ادائیگی کی شرائط:</h4>
                <ul>
                    <li>ادائیگیاں انوائس کی تاریخ سے 7 دنوں کے اندر واجب الادا ہیں۔</li>
                    <li>اگر کوئی ادائیگی منسوخ ہو جائے تو کمپنی قانونی کارروائی کرنے کا حق محفوظ رکھتی ہے۔</li>
                </ul>

                <h4>۱۰۔ ذمہ داری سے دستبرداری:</h4>
                <ul>
                    <li>
                        کمپنی ویزا منظوری کی ضمانت نہیں دیتی اور ویزا منظوری کی سرکاری تصدیق سے پہلے کیے گئے کسی بھی سفری انتظامات کے لیے ذمہ دار نہیں۔
                    </li>
                    <li>
                        کمپنی درخواست کے عمل کے دوران سرکاری ضوابط یا عمل میں ہونے والی کسی بھی تبدیلی کے لیے ذمہ دار نہیں۔
                    </li>
                </ul>

                <h4>۱۱۔ معاہدے کا خاتمہ:</h4>
                <p>
                    اگر کلائنٹ مقررہ شرائط پر عمل کرنے میں ناکام رہے، بشمول ادائیگی نہ کرنا، مطلوبہ دستاویزات جمع نہ کرنا، یا کمپنی کی ساکھ کو نقصان پہنچانے کی کوئی بھی کوشش، تو کمپنی اس معاہدے کو ختم کرنے کا حق محفوظ رکھتی ہے۔
                </p>

                <h4>۱۲۔ بہتان اور غیر منصفانہ تبصرے کی شق</h4>
                <p>
                    کلائنٹ اس بات پر متفق ہے کہ فالکن انٹرنیشنل کنسلٹنٹس اور اس کی خدمات کے بارے میں کوئی بھی عوامی بیان، جائزہ یا تبصرہ سچا اور اصل تجربات پر مبنی ہونا چاہیے۔ کلائنٹ کی طرف سے کوئی بھی جھوٹا، گمراہ کن، بہتانہ یا ناانصافانہ بیان، چاہے زبانی ہو، تحریری ہو، یا آن لائن پوسٹ کیا گیا ہو، جو فالکن انٹرنیشنل کنسلٹنٹس کی ساکھ کو منفی طور پر متاثر کرے، اس معاہدے کی خلاف ورزی سمجھی جائے گی۔
                </p>
            </div>

            <!-- Footer -->
            <div class="footer-right">
                <img src="{{ $scanner }}" alt="scanner" />
            </div>
        </div>

        <!-- Page 9 - Urdu Translation Final -->
        <div class="page" style="font-family: 'Noto Naskh Arabic', sans-serif; font-size: 14px;">
            <!-- Header -->
            <div class="header-with-border" style="text-align: center;">
                <img src="{{ $logo }}" />
            </div>

            <!-- Terms Continued -->
            <div style="margin-top: 10px">
                <p>
                    ایسی خلاف ورزی کی صورت میں، فالکن انٹرنیشنل کنسلٹنٹس نقصانات کے لیے قانونی کارروائی کرنے کا حق محفوظ رکھتی ہے، جس میں ساکھ کو نقصان، کاروبار کا نقصان، یا کوئی دیگر متعلقہ اخراجات شامل ہیں لیکن ان تک محدود نہیں۔ مزید یہ کہ فالکن انٹرنیشنل کنسلٹنٹس بغیر پیشگی نوٹس کے کلائنٹ کے ساتھ کسی بھی جاری خدمات یا معاہدوں کو ختم کر سکتی ہے۔
                </p>

                <h4>واپسی کی شق:</h4>

                <p><strong>۱۔ کمپنی کو بغیر رقم واپس کیے خدمات ختم کرنے کا حق ہے اگر کلائنٹ:</strong></p>

                <ul>
                    <li>رجسٹریشن کے 30 دنوں کے اندر دستاویزات جمع کرنے میں ناکام رہے۔</li>
                    <li>کمپنی کی اجازت کے بغیر کسی سرکاری ادارے سے براہِ راست رابطہ کرے۔</li>
                    <li>30 دنوں کے اندر کمپنی کی مواصلت کا جواب دینے میں ناکام رہے۔</li>
                    <li>اپنی مرضی سے عمل سے دستبردار ہو جائے۔</li>
                    <li>
                        مطلوبہ امتحانات پاس کرنے، طبی کلیئرنس فراہم کرنے، یا درست پولیس کلیئرنس سرٹیفکیٹ جمع کرنے میں ناکام رہے۔
                    </li>
                    <li>ویزا درخواست کے لیے کافی فنڈز ثابت کرنے میں ناکام رہے۔</li>
                </ul>

                <h4 style="margin-top: 10px; margin-bottom: 10px">ادائیگی کی تفصیلات<span style="font-family: Arial, sans-serif;">:</span></h4>

                <p style="margin: 0">کل معاہدے کی رقم<span style="font-family: Arial, sans-serif;">: {{ $Contract_Amount }}</span></p>
                <p style="margin: 0">رجسٹریشن<span style="font-family: Arial, sans-serif;">: {{ $Registration }}</span></p>
                <p style="margin: 0">جاب آفر لیٹر موصول ہونے پر<span style="font-family: Arial, sans-serif;">: {{ $On_Receiving_job_Offer_Letter_Amount }}</span></p>
                <p style="margin: 0">ورک پرمٹ موصول ہونے پر<span style="font-family: Arial, sans-serif;">: {{ $On_Receiving_Work_Permit_Amount }}</span></p>
                <p style="margin: 0">سفارت خانے کی اپائنٹمنٹ موصول ہونے پر<span style="font-family: Arial, sans-serif;">: {{ $On_Receiving_Embassy_Appointment }}</span></p>
                <p style="margin: 0">ویزا کے بعد رقم<span style="font-family: Arial, sans-serif;">: {{ $After_Visa_Amount }}</span></p>
                <p style="margin: 0">فلائٹ ٹکٹ<span style="font-family: Arial, sans-serif;">: {{ $Flight_Ticket }}</span></p>
                <p style="margin: 0">
                    ذیل میں دستخط کر کے، دونوں فریق اس معاہدے میں بیان کردہ شرائط و ضوابط سے اتفاق کرتے ہیں۔
                </p>
            </div>

            <!-- Signature Area -->
            <div style="margin-top: 30px">
                <div>
                    <p style="margin: 0 0 6px; font-weight: 600">کلائنٹ کے دستخط<span style="font-family: Arial, sans-serif;">: _____________________</span></p>
                    <p style="margin: 0 0 6px; font-weight: 600">تاریخ<span style="font-family: Arial, sans-serif;">: {{ $date }}</span></p>

                    <p style="margin: 0 0 6px; font-weight: 600">
                        کمپنی کے نمائندے کے دستخط<span style="font-family: Arial, sans-serif;">: _____________________</span>
                    </p>
                    <p style="margin: 0 0 6px; font-weight: 600">تاریخ<span style="font-family: Arial, sans-serif;">: {{ $date }}</span></p>
                </div>
            </div>

            <!-- Footer -->
            <div class="footer-right">
                <img src="{{ $scanner }}" alt="scanner" />
            </div>
        </div>
    </body>
</html>
