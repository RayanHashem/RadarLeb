<template>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bungee&display=swap" rel="stylesheet">
<!--     <link href="https://db.onlinewebfonts.com/c/85040c569cc6193905af9f9ee765baf4?family=GE+Flow" rel="stylesheet"> -->



<div v-if="activeOverlay" class="overlay"

  @click.self="activeOverlay = null"
style="background: none !important;">

  <div class="overlay-blur"></div>
  <div class="overlay-content">
    <p dir="rtl" style=" margin: auto; font-family: GE Flow;">



      <template v-if="activeOverlay === 'help'">
         <p dir="rtl" style="width: 80%; margin: auto; font-family:GE Flow;">
RADAR LEB
<br>


        هي لعبة ممتعة تجمع بين الاستراتيجيةوالحظ. الهدف الرئيسي من اللعبة هو قيام اللاعبين بمسح من عدة مناطق على طول الأراضي اللبنانية وجمع الهوائيات باستخدام واجهة رادار. كل عملية مسح ناجحة تضيف إلى عداد الهوائيات الخاص باللاعب. عند اكتشاف ستة هوائيات نشطة, يفوز اللاعب بعد اختياره من مجموعة متنوعة من الجوائز القيمة, بما في ذلك الهواتف المحمولة, الإلكترونيات, الدراجات النارية, سيارات الدفع الرباعي والسيارات الخارقة.
<br><br>

كيفية المشاركة ولعب RADAR LEB
<br><br>

1- قم بتحميل تطبيق WISH OR OMT OR SUYOOLعلى هاتفك او خدمة DOOR TO DOOR PICK UP CASH
<br>2- اشحن محفظتك بالدولار بالمبلغ الأدنى المذكور في النص أدناه, ثم قم بتحويل المبلغ إلى الرقم 71484833 وأكد التحويل عبر خدمة الواتساب مع إضافة اسمك الكامل ورقم الهاتف ومبلغ الحد الأدنى المطلوب لكل جائزة ب ال NOTE OR REASON
<br>3- تحتاج عملية تشريج الرادارات إلى محفظتك ل٢٤ ساعة كحد أقصى
<br>4- اضغط على الجائزة التي تختارها
<br>5- اضغط على زر المسح الضوئي SCAN الذي يساعدك على اكتشاف الهوائيات الموزعة على كافة المناطق اللبنانية
<br>6- بمجرد مسح واكتشاف ستة هوائيات نشطة, يفوز اللاعب بالجائزة المختارة
<br>ملاحظة: يجب استخدام زر المسح الضوئي في مواقع مختلفة داخل الأراضي اللبنانية لضمان اكتشاف الهوائيات النشطة, بعد اعلان ربح كل جائزة خيار زر RADAR ONLINE سيتحول إلى RADAR ONLINE ليتم توقيف زر ال للمشتركين لوقت قصير للتمكن من التحضير للجائزة التالية, بعد عملية تشريج الرادارات إلى محفظتك لا يسمح للمشترك المطالبة بإعادة المبلغ نقدا
يحق فقط لرابح الجائزة أن يستلمها </p>
      </template>

      <template v-else-if="activeOverlay === 'winners'">
       <h1 style="text-align: center;"> WINNERS </h1>


<div class="winner" style="color:#04333f;">

 <img class="user" src="/assets/imgs/winner.png"  />
<div class="text-block">


 <span class="subt"> Kenan Salloum  </span>

<u class="subt">  Winner draw 1 -SUV </u>
</div>

</div>

<p class="winner"><img class="user" src="/assets/imgs/winner.png"  />
 Kenan Salloum </p>

<p class="winner"><img class="user" src="/assets/imgs/winner.png"  />
 Kenan Salloum </p>


      </template>



 <template v-else-if="activeOverlay === 'settings'">


  <div class="container" id="settingsPage" style="text-align: center;">
 <div v-if="currentPage === 'settings'">
      <h1>SETTINGS</h1>
      <button
        :class="musicOn ? 'a-btn a-btn-music-on' : 'a-btn a-btn-music-off'"
        @click="toggleMusic"
      >
        Music
      </button>
      <button class="a-btn a-btn-default" @click="currentPage = 'password'">
        Change Password
      </button>
    </div>

    <div v-else-if="currentPage === 'password'">
      <h1>SETTINGS</h1>
      <input
        type="password"
        placeholder="Change Your Password!"
        v-model="newPassword"
        class="a-input"
      />
      <input
        type="password"
        placeholder="Confirm Your Password!"
        v-model="confirmPassword"
        class="a-input"
      />
      <button class="a-btn a-btn-music-on" @click="currentPage = 'settings'">
        Done
      </button>
    </div>
    </div>


      </template>





    </p>
  </div>
</div>






















    <div class="overlay" style="display: none">
        <h1>
            Congratulations
        </h1>
        <h2>
            you are a winner
        </h2>
        <h2>
            Pick prize
        </h2>
    </div>
    <div class="overlay" style="display: none">
        <div class="pb-3">
            <h1>
                Winners
            </h1>
        </div>
        <div class="d-flex flex-column gap-4">
            <div class="card">
                <div class="icon-box flex-row">
                    <div class="icon-box-2">
                        <svg width="41" height="41" viewBox="0 0 41 41" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M40.4462 36.702C37.8755 32.0942 33.8614 28.5038 29.05 26.509C31.4426 24.6763 33.21 22.1212 34.1018 19.2057C34.9935 16.2902 34.9645 13.162 34.0187 10.2643C33.0729 7.36659 31.2584 4.84624 28.8321 3.06026C26.4058 1.27429 23.4908 0.313232 20.5 0.313232C17.5091 0.313232 14.5941 1.27429 12.1678 3.06026C9.74156 4.84624 7.92701 7.36659 6.98122 10.2643C6.03544 13.162 6.00638 16.2902 6.89814 19.2057C7.78991 22.1212 9.5573 24.6763 11.95 26.509C7.13857 28.5038 3.12442 32.0942 0.553711 36.702C0.394421 36.9635 0.288254 37.2552 0.241524 37.5595C0.194793 37.8638 0.208452 38.1746 0.281688 38.4734C0.354924 38.7722 0.486243 39.053 0.667838 39.2989C0.849432 39.5449 1.0776 39.751 1.33876 39.9052C1.59993 40.0593 1.88877 40.1581 2.18811 40.196C2.48745 40.2338 2.79118 40.2098 3.08125 40.1253C3.37131 40.0408 3.64179 39.8977 3.8766 39.7043C4.11141 39.511 4.30575 39.2714 4.44809 38.9998C7.84559 33.0024 13.8456 29.4254 20.5 29.4254C27.1543 29.4254 33.1543 33.0043 36.5518 38.9998C36.8603 39.5064 37.3496 39.8706 37.9162 40.0154C38.4828 40.1602 39.0823 40.0744 39.5881 39.776C40.0938 39.4775 40.4661 38.99 40.6263 38.4163C40.7864 37.8427 40.7218 37.2279 40.4462 36.702ZM10.75 14.8722C10.75 12.9028 11.3218 10.9776 12.3931 9.34011C13.4645 7.70261 14.9872 6.42634 16.7688 5.67269C18.5504 4.91903 20.5108 4.72184 22.4021 5.10605C24.2934 5.49026 26.0307 6.43862 27.3943 7.83119C28.7578 9.22376 29.6864 10.998 30.0626 12.9296C30.4388 14.8611 30.2457 16.8632 29.5078 18.6827C28.7698 20.5022 27.5202 22.0573 25.9168 23.1515C24.3134 24.2456 22.4283 24.8296 20.5 24.8296C17.915 24.8266 15.4368 23.7765 13.609 21.9098C11.7811 20.0431 10.7529 17.5121 10.75 14.8722Z" fill="white"/>
                        </svg>
                    </div>
                    <div>
                        <h4 style="color: #5DB0A1">
                            Winner Draw 1 - Bike
                        </h4>
                        <h3>ali hdib</h3>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="icon-box flex-row">
                    <div class="icon-box-2">
                        <svg width="41" height="41" viewBox="0 0 41 41" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M40.4462 36.702C37.8755 32.0942 33.8614 28.5038 29.05 26.509C31.4426 24.6763 33.21 22.1212 34.1018 19.2057C34.9935 16.2902 34.9645 13.162 34.0187 10.2643C33.0729 7.36659 31.2584 4.84624 28.8321 3.06026C26.4058 1.27429 23.4908 0.313232 20.5 0.313232C17.5091 0.313232 14.5941 1.27429 12.1678 3.06026C9.74156 4.84624 7.92701 7.36659 6.98122 10.2643C6.03544 13.162 6.00638 16.2902 6.89814 19.2057C7.78991 22.1212 9.5573 24.6763 11.95 26.509C7.13857 28.5038 3.12442 32.0942 0.553711 36.702C0.394421 36.9635 0.288254 37.2552 0.241524 37.5595C0.194793 37.8638 0.208452 38.1746 0.281688 38.4734C0.354924 38.7722 0.486243 39.053 0.667838 39.2989C0.849432 39.5449 1.0776 39.751 1.33876 39.9052C1.59993 40.0593 1.88877 40.1581 2.18811 40.196C2.48745 40.2338 2.79118 40.2098 3.08125 40.1253C3.37131 40.0408 3.64179 39.8977 3.8766 39.7043C4.11141 39.511 4.30575 39.2714 4.44809 38.9998C7.84559 33.0024 13.8456 29.4254 20.5 29.4254C27.1543 29.4254 33.1543 33.0043 36.5518 38.9998C36.8603 39.5064 37.3496 39.8706 37.9162 40.0154C38.4828 40.1602 39.0823 40.0744 39.5881 39.776C40.0938 39.4775 40.4661 38.99 40.6263 38.4163C40.7864 37.8427 40.7218 37.2279 40.4462 36.702ZM10.75 14.8722C10.75 12.9028 11.3218 10.9776 12.3931 9.34011C13.4645 7.70261 14.9872 6.42634 16.7688 5.67269C18.5504 4.91903 20.5108 4.72184 22.4021 5.10605C24.2934 5.49026 26.0307 6.43862 27.3943 7.83119C28.7578 9.22376 29.6864 10.998 30.0626 12.9296C30.4388 14.8611 30.2457 16.8632 29.5078 18.6827C28.7698 20.5022 27.5202 22.0573 25.9168 23.1515C24.3134 24.2456 22.4283 24.8296 20.5 24.8296C17.915 24.8266 15.4368 23.7765 13.609 21.9098C11.7811 20.0431 10.7529 17.5121 10.75 14.8722Z" fill="white"/>
                        </svg>
                    </div>
                    <div>
                        <h4 style="color: #5DB0A1">
                            Winner Draw 1 - Bike
                        </h4>
                        <h3>ali hdib</h3>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="icon-box flex-row">
                    <div class="icon-box-2">
                        <svg width="41" height="41" viewBox="0 0 41 41" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M40.4462 36.702C37.8755 32.0942 33.8614 28.5038 29.05 26.509C31.4426 24.6763 33.21 22.1212 34.1018 19.2057C34.9935 16.2902 34.9645 13.162 34.0187 10.2643C33.0729 7.36659 31.2584 4.84624 28.8321 3.06026C26.4058 1.27429 23.4908 0.313232 20.5 0.313232C17.5091 0.313232 14.5941 1.27429 12.1678 3.06026C9.74156 4.84624 7.92701 7.36659 6.98122 10.2643C6.03544 13.162 6.00638 16.2902 6.89814 19.2057C7.78991 22.1212 9.5573 24.6763 11.95 26.509C7.13857 28.5038 3.12442 32.0942 0.553711 36.702C0.394421 36.9635 0.288254 37.2552 0.241524 37.5595C0.194793 37.8638 0.208452 38.1746 0.281688 38.4734C0.354924 38.7722 0.486243 39.053 0.667838 39.2989C0.849432 39.5449 1.0776 39.751 1.33876 39.9052C1.59993 40.0593 1.88877 40.1581 2.18811 40.196C2.48745 40.2338 2.79118 40.2098 3.08125 40.1253C3.37131 40.0408 3.64179 39.8977 3.8766 39.7043C4.11141 39.511 4.30575 39.2714 4.44809 38.9998C7.84559 33.0024 13.8456 29.4254 20.5 29.4254C27.1543 29.4254 33.1543 33.0043 36.5518 38.9998C36.8603 39.5064 37.3496 39.8706 37.9162 40.0154C38.4828 40.1602 39.0823 40.0744 39.5881 39.776C40.0938 39.4775 40.4661 38.99 40.6263 38.4163C40.7864 37.8427 40.7218 37.2279 40.4462 36.702ZM10.75 14.8722C10.75 12.9028 11.3218 10.9776 12.3931 9.34011C13.4645 7.70261 14.9872 6.42634 16.7688 5.67269C18.5504 4.91903 20.5108 4.72184 22.4021 5.10605C24.2934 5.49026 26.0307 6.43862 27.3943 7.83119C28.7578 9.22376 29.6864 10.998 30.0626 12.9296C30.4388 14.8611 30.2457 16.8632 29.5078 18.6827C28.7698 20.5022 27.5202 22.0573 25.9168 23.1515C24.3134 24.2456 22.4283 24.8296 20.5 24.8296C17.915 24.8266 15.4368 23.7765 13.609 21.9098C11.7811 20.0431 10.7529 17.5121 10.75 14.8722Z" fill="white"/>
                        </svg>
                    </div>
                    <div>
                        <h4 style="color: #5DB0A1">
                            Winner Draw 1 - Bike
                        </h4>
                        <h3>ali hdib</h3>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="icon-box flex-row">
                    <div class="icon-box-2">
                        <svg width="41" height="41" viewBox="0 0 41 41" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M40.4462 36.702C37.8755 32.0942 33.8614 28.5038 29.05 26.509C31.4426 24.6763 33.21 22.1212 34.1018 19.2057C34.9935 16.2902 34.9645 13.162 34.0187 10.2643C33.0729 7.36659 31.2584 4.84624 28.8321 3.06026C26.4058 1.27429 23.4908 0.313232 20.5 0.313232C17.5091 0.313232 14.5941 1.27429 12.1678 3.06026C9.74156 4.84624 7.92701 7.36659 6.98122 10.2643C6.03544 13.162 6.00638 16.2902 6.89814 19.2057C7.78991 22.1212 9.5573 24.6763 11.95 26.509C7.13857 28.5038 3.12442 32.0942 0.553711 36.702C0.394421 36.9635 0.288254 37.2552 0.241524 37.5595C0.194793 37.8638 0.208452 38.1746 0.281688 38.4734C0.354924 38.7722 0.486243 39.053 0.667838 39.2989C0.849432 39.5449 1.0776 39.751 1.33876 39.9052C1.59993 40.0593 1.88877 40.1581 2.18811 40.196C2.48745 40.2338 2.79118 40.2098 3.08125 40.1253C3.37131 40.0408 3.64179 39.8977 3.8766 39.7043C4.11141 39.511 4.30575 39.2714 4.44809 38.9998C7.84559 33.0024 13.8456 29.4254 20.5 29.4254C27.1543 29.4254 33.1543 33.0043 36.5518 38.9998C36.8603 39.5064 37.3496 39.8706 37.9162 40.0154C38.4828 40.1602 39.0823 40.0744 39.5881 39.776C40.0938 39.4775 40.4661 38.99 40.6263 38.4163C40.7864 37.8427 40.7218 37.2279 40.4462 36.702ZM10.75 14.8722C10.75 12.9028 11.3218 10.9776 12.3931 9.34011C13.4645 7.70261 14.9872 6.42634 16.7688 5.67269C18.5504 4.91903 20.5108 4.72184 22.4021 5.10605C24.2934 5.49026 26.0307 6.43862 27.3943 7.83119C28.7578 9.22376 29.6864 10.998 30.0626 12.9296C30.4388 14.8611 30.2457 16.8632 29.5078 18.6827C28.7698 20.5022 27.5202 22.0573 25.9168 23.1515C24.3134 24.2456 22.4283 24.8296 20.5 24.8296C17.915 24.8266 15.4368 23.7765 13.609 21.9098C11.7811 20.0431 10.7529 17.5121 10.75 14.8722Z" fill="white"/>
                        </svg>
                    </div>
                    <div>
                        <h4 style="color: #5DB0A1">
                            Winner Draw 1 - Bike
                        </h4>
                        <h3>ali hdib</h3>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div>

        <section
            v-if="loading"
            id="loading-game"
            class="w-100 position-fixed top-0 start-0 h-100 bg-white d-flex flex-column justify-content-center align-items-center"
            style="z-index: 1000;"
        >
            <div class="d-flex justify-content-between align-items-center flex-column h-100 p-3-5 overflow-auto">
                <div class="d-flex gap-4 flex-column w-100 align-items-center">
                    <img src="/assets/imgs/cir.png" class="cir" />
                    <img src="/assets/imgs/Flag_of_Lebanon.png" class="flag-2" />
                    <img src="/assets/imgs/port-beirut.png" class="port" />
                    <div class="circle-loader">
  <svg viewBox="0 0 100 100" class="circle-loader-svg">
    <circle class="circle-bg" cx="50" cy="50" r="45" />
    <circle class="circle-progress" cx="50" cy="50" r="45" />
  </svg>
</div>

                </div>

            </div>
        </section>

        <!-- 2️⃣ Actual game UI -->
        <section
            v-show="!loading"
            id="game"
            class="w-100"
        >


        <video autoplay
               :muted="true"
               loop playsinline id="myVideo">
        <source src="/assets/imgs/vid.webm" type="video/mp4">
        Your browser does not support HTML5 video.
        </video>





            <div class="d-flex justify-content-between align-items-center flex-column h-100 p-3-5" style="padding:0px !important;">
                <div class="d-flex gap-4 flex-row w-100 justify-content-between bar">
                    <img src="assets/imgs/logo.png" class="logo-nav" style="margin:auto; margin-left: 3%;">

                     <div class="icon-box" style="margin:auto;">
                            <div :class="['icon-box-2', radarOnline ? 'green' : 'red']">
                                <svg></svg>
                            </div>

                        </div>


                    <div class="d-flex gap-4">

                   <img
  src="/assets/imgs/winners-button.png"
  class="menu-item"
  @click="activeOverlay = 'winners'"
/>

             <img     src="/assets/imgs/help-button.png"
  class="menu-item"
  @click="activeOverlay = 'help'"
  />




                    <img src="/assets/imgs/settings-button.png" class="menu-item"
                    @click="activeOverlay = 'settings'"
                    />



                    </div>
                </div>
                <div class="d-flex align-items-center justify-content-between w-100 row" style="z-index:1;">
                    <div class="col-2 d-flex flex-column gap-3 align-items-center">
                        <div class="icon-box">
                            <div class="icon-box-2">
                                <svg width="13" height="13" viewBox="0 0 13 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_60_717)">
                                        <path d="M11.9716 11.3358L11.1731 8.93974H10.2969L10.7835 11.2762H2.21666L2.70324 8.93974H1.82705L1.02796 11.3358C0.825272 11.9457 1.18451 12.4445 1.82705 12.4445H11.1731C11.8156 12.4445 12.1749 11.9457 11.9716 11.3358ZM9.4207 3.6826C9.4207 2.908 9.11299 2.16512 8.56527 1.6174C8.01754 1.06967 7.27467 0.761963 6.50007 0.761963C5.72547 0.761963 4.98259 1.06967 4.43486 1.6174C3.88714 2.16512 3.57943 2.908 3.57943 3.6826C3.57943 6.4718 6.50007 9.52387 6.50007 9.52387C6.50007 9.52387 9.4207 6.4718 9.4207 3.6826ZM4.92292 3.71765C4.92292 3.51056 4.96372 3.3055 5.04299 3.11419C5.12225 2.92287 5.23843 2.74905 5.38489 2.60264C5.53135 2.45624 5.70522 2.34012 5.89656 2.26093C6.08791 2.18173 6.29298 2.14101 6.50007 2.14109C6.91827 2.14109 7.31935 2.30722 7.61507 2.60294C7.91078 2.89865 8.07692 3.29973 8.07692 3.71794C8.07692 4.13614 7.91078 4.53722 7.61507 4.83294C7.31935 5.12866 6.91827 5.29479 6.50007 5.29479C6.08178 5.29479 5.68063 5.12863 5.38486 4.83285C5.08909 4.53708 4.92292 4.13593 4.92292 3.71765Z" fill="white"/>
                                    </g>
                                    <defs>
                                        <clipPath id="clip0_60_717">
                                            <rect width="11.6825" height="11.6825" fill="white" transform="translate(0.658691 0.761963)"/>
                                        </clipPath>
                                    </defs>
                                </svg>
                            </div>
                            <span>
                            antenna <br> Detection
                        </span>
                        </div>
                        <div class="bar-container">
                            <div
                                v-for="(color, idx) in originalColors"
                                :key="idx"
                                class="bar"
                                :style="{
        backgroundColor: idx >= originalColors.length - visibleCount
                          ? barColor(idx)
                          : 'transparent'
      }"
                            ></div>
<!--                            <div class="bar" style="background: #E45A73"></div>-->
<!--                            <div class="bar" style="background: #E45A73"></div>-->
<!--                            <div class="bar" style="background: #E45A73"></div>-->
<!--                            <div class="bar" style="background: #E45A73"></div>-->
<!--                            <div class="bar" style="background: #E45A73"></div>-->
<!--                            <div class="bar" style="background: #E45A73"></div>-->
<!--                            <div class="bar" style="background: #E45A73"></div>-->
<!--                            <div class="bar" style="background: #E45A73"></div>-->
                        </div>
                    </div>

                    <div class="col-8 py-3">


                        <div class="radar">
                        <!--     <video  autoplay muted loop id="myVideo2"><source  src="/assets/imgs/radar.mp4" type="video/mp4"> Your browser does not support HTML5 video. </video>-->
                        </div>
                    </div>
                    <div class="col-2 d-flex flex-column gap-3 py-3 align-items-center">


                  <img class="selectable" style="width:100px;" src="/assets/imgs/mobile.png" />
                                      <h1>okayyy</h1>

                    <img class="selectable" style="width:100px;" src="/assets/imgs/bike-and-electronics.png" />
                    <img class="selectable" style="width:100px;" src="/assets/imgs/suv.png" />
                    <img class="selectable" style="width:100px;" src="/assets/imgs/super-car.png" />
                    <img class="selectable" style="width:100px;" src="/assets/imgs/muscle-car.png" />

<template>
  <div>
    <img
      v-for="(image, index) in images"
      :key="image.name"
      class="selectable"
      :style="{ width: '100px', cursor: 'pointer', border: image.isSelected ? '3px solid #4CAF50' : 'none' }"
      :src="image.isSelected ? image.detectedSrc : image.baseSrc"
      @click="selectImage(index)"
      alt="vehicle"
    />
  </div>
</template>




                        <!--
                        <div class="icon-box"
                             :class="{ selected: selectedGameId === games[0].id }"
                             @click="selectPrize(games[0].id)">
                            <div class="icon-box-2">
                             <img style="width:20px;" src="/assets/imgs/mobile.png" />
                            </div>
                            <span>
                            MOBILE <br> $ {{ format(games[0].price) }}
                        </span>
                        </div>
                        <div class="icon-box"    :class="{ selected: selectedGameId === games[1].id }"
                             @click="selectPrize(games[1].id)">
                            <div class="icon-box-2">
                                <svg width="16" height="27" viewBox="0 0 16 27" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M12.9018 12.5946C13.8042 12.5946 14.5358 11.8631 14.5358 10.9606C14.5358 10.0582 13.8042 9.32666 12.9018 9.32666C11.9994 9.32666 11.2678 10.0582 11.2678 10.9606C11.2678 11.8631 11.9994 12.5946 12.9018 12.5946Z" stroke="white" stroke-width="0.735294" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M3.09779 12.5946C4.00022 12.5946 4.73178 11.8631 4.73178 10.9606C4.73178 10.0582 4.00022 9.32666 3.09779 9.32666C2.19537 9.32666 1.46381 10.0582 1.46381 10.9606C1.46381 11.8631 2.19537 12.5946 3.09779 12.5946Z" stroke="white" stroke-width="0.735294" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M13.3823 5.32015C14.2196 6.33911 14.5111 7.30839 14.5353 7.82081C14.0805 7.61311 13.5862 7.50631 13.0863 7.50773C11.4882 7.50773 10.0536 8.57048 9.7111 9.98617C9.62875 10.3247 9.58822 10.494 9.49933 10.5639C9.41044 10.6339 9.26665 10.6339 8.97973 10.6339H7.09868C6.80914 10.6339 6.66469 10.6339 6.5758 10.5633C6.48626 10.4914 6.44705 10.3234 6.36927 9.98617C6.04509 8.58878 4.73005 7.37375 3.36077 7.47636C3.22286 7.48747 3.15358 7.4927 3.10587 7.48159C3.05946 7.47113 3.01175 7.44434 2.91633 7.39009C2.64116 7.23519 2.36012 7.08747 2.09018 6.92342C1.90515 6.81065 1.75105 6.65365 1.64175 6.46654C1.53246 6.27943 1.47139 6.06809 1.46404 5.85153C1.45554 5.60054 1.59933 5.35218 1.89018 5.42015L6.08626 6.40773C6.40195 6.48224 6.55946 6.51885 6.69476 6.49401C6.83005 6.46917 6.99672 6.35545 7.32875 6.128C8.17058 5.55283 9.50522 5.00839 10.8353 5.48878C11.1993 5.62015 11.3817 5.68617 11.485 5.68943C11.5895 5.6927 11.7412 5.64826 12.0451 5.56002C12.4805 5.43144 12.9287 5.351 13.3817 5.32015C12.8575 4.68094 12.1176 4.02277 11.0941 3.44434" stroke="white" stroke-width="0.735294" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M7.61659 18.2908H5.2058V18.8869H6.20384V21.7447H6.92688V18.8869H7.81708L8.77786 21.7447H9.64845L10.8097 18.2908H10.022L9.23228 21.0001H9.21561L8.42541 18.2908H7.61659ZM3.09796 16.8427C3.09796 16.7127 3.14961 16.588 3.24154 16.4961C3.33347 16.4042 3.45815 16.3525 3.58816 16.3525H12.4117C12.5417 16.3525 12.6664 16.4042 12.7583 16.4961C12.8502 16.588 12.9019 16.7127 12.9019 16.8427V23.2153C12.9019 23.3453 12.8502 23.47 12.7583 23.5619C12.6664 23.6538 12.5417 23.7055 12.4117 23.7055H3.58816C3.45815 23.7055 3.33347 23.6538 3.24154 23.5619C3.14961 23.47 3.09796 23.3453 3.09796 23.2153V16.8427ZM6.03914 24.7104C6.03914 24.5074 6.20777 24.3427 6.40826 24.3427H9.59159C9.63999 24.3425 9.68796 24.3519 9.73273 24.3703C9.77751 24.3887 9.81821 24.4157 9.85251 24.4499C9.8868 24.4841 9.91401 24.5246 9.93258 24.5693C9.95115 24.6141 9.96071 24.662 9.96071 24.7104V25.078H6.03914V24.7104Z" fill="white"/>
                                </svg>
                            </div>
                            <span>
                            BIKE/ELECTRONICS  <br>
                            electronics  <br>
                            $ {{ format(games[1].price) }}
                        </span>
                        </div>
                        <div class="icon-box"     :class="{ selected: selectedGameId === games[2].id }"
                             @click="selectPrize(games[2].id)">
                            <div class="icon-box-2">
                                <svg width="22" height="13" viewBox="0 0 22 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M2.1763 0.48999H14.9214L17.8626 4.41156H19.8234C20.9116 4.41156 21.7841 5.28411 21.7841 6.37234V9.31352H19.8234C19.8234 10.0936 19.5135 10.8417 18.9619 11.3932C18.4103 11.9448 17.6622 12.2547 16.8822 12.2547C16.1021 12.2547 15.354 11.9448 14.8025 11.3932C14.2509 10.8417 13.941 10.0936 13.941 9.31352H8.05865C8.05865 10.0936 7.74878 10.8417 7.1972 11.3932C6.64562 11.9448 5.89752 12.2547 5.11748 12.2547C4.33743 12.2547 3.58933 11.9448 3.03775 11.3932C2.48617 10.8417 2.1763 10.0936 2.1763 9.31352H0.215515V2.45077C0.215515 1.36254 1.08806 0.48999 2.1763 0.48999ZM1.6861 1.96058V4.41156H9.52924V1.96058H1.6861ZM10.9998 1.96058V4.41156H16.039L14.1861 1.96058H10.9998ZM5.11748 7.84293C4.72745 7.84293 4.3534 7.99787 4.07761 8.27366C3.80182 8.54945 3.64689 8.9235 3.64689 9.31352C3.64689 9.70354 3.80182 10.0776 4.07761 10.3534C4.3534 10.6292 4.72745 10.7841 5.11748 10.7841C5.5075 10.7841 5.88155 10.6292 6.15734 10.3534C6.43313 10.0776 6.58806 9.70354 6.58806 9.31352C6.58806 8.9235 6.43313 8.54945 6.15734 8.27366C5.88155 7.99787 5.5075 7.84293 5.11748 7.84293ZM16.8822 7.84293C16.4922 7.84293 16.1181 7.99787 15.8423 8.27366C15.5665 8.54945 15.4116 8.9235 15.4116 9.31352C15.4116 9.70354 15.5665 10.0776 15.8423 10.3534C16.1181 10.6292 16.4922 10.7841 16.8822 10.7841C17.2722 10.7841 17.6463 10.6292 17.922 10.3534C18.1978 10.0776 18.3528 9.70354 18.3528 9.31352C18.3528 8.9235 18.1978 8.54945 17.922 8.27366C17.6463 7.99787 17.2722 7.84293 16.8822 7.84293Z" fill="white"/>
                                </svg>
                            </div>
                            <span>
                            SUV <br> $ {{ format(games[2].price) }}
                        </span>
                        </div>
                        <div class="icon-box"     :class="{ selected: selectedGameId === games[3].id }"
                             @click="selectPrize(games[3].id)">
                            <div class="icon-box-2">
                                <svg width="24" height="7" viewBox="0 0 24 7" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M17.1203 5.39675C17.1202 5.6482 17.1947 5.89403 17.3343 6.10316C17.4739 6.31228 17.6724 6.4753 17.9047 6.57159C18.137 6.66789 18.3926 6.69314 18.6392 6.64415C18.8859 6.59515 19.1124 6.47412 19.2903 6.29635C19.4681 6.11858 19.5892 5.89207 19.6383 5.64546C19.6874 5.39885 19.6623 5.14321 19.5661 4.91089C19.4699 4.67857 19.3069 4.48 19.0979 4.34029C18.8888 4.20058 18.643 4.12601 18.3915 4.12601C18.0546 4.12628 17.7314 4.26023 17.4931 4.49847C17.2548 4.7367 17.1207 5.05976 17.1203 5.39675ZM4.16193 4.12601C4.41324 4.12611 4.65887 4.20072 4.86778 4.34042C5.07668 4.48011 5.23948 4.67861 5.33558 4.91081C5.43168 5.14302 5.45677 5.3985 5.40768 5.64497C5.35859 5.89144 5.23752 6.11781 5.05979 6.29548C4.88205 6.47314 4.65562 6.59412 4.40914 6.64311C4.16265 6.6921 3.90718 6.6669 3.67501 6.57071C3.44284 6.47451 3.24441 6.31164 3.1048 6.10268C2.9652 5.89372 2.89068 5.64805 2.89068 5.39675C2.89109 5.05985 3.0251 4.73687 3.26332 4.49865C3.50154 4.26043 3.82452 4.12642 4.16142 4.12601H4.16193ZM0.234985 0.46284H3.67945L2.98236 2.9869L7.69449 0.411621H10.6324L10.6969 2.18789L12.3359 2.94388L12.9373 2.20428H13.7373L13.8991 3.02378C20.9448 2.35794 23.7644 4.51783 23.7644 4.51783C23.7644 4.51783 23.3792 4.77393 22.4363 4.94756C22.2376 5.11709 22.2488 5.68716 22.2488 5.68716H23.4883V6.50666H20.8249V5.09917C20.7307 5.10275 20.597 5.12017 20.4633 5.12324C20.4238 4.8235 20.3197 4.53591 20.1582 4.28031C19.9967 4.0247 19.7817 3.80718 19.528 3.64273C19.2743 3.47828 18.9879 3.37082 18.6887 3.32778C18.3894 3.28473 18.0844 3.30712 17.7946 3.39339C17.5048 3.47967 17.2372 3.62778 17.0103 3.8275C16.7833 4.02723 16.6023 4.27381 16.4799 4.55025C16.3575 4.82669 16.2965 5.1264 16.3011 5.4287C16.3057 5.73101 16.3759 6.02871 16.5067 6.30127H6.04576C6.18141 6.01831 6.25161 5.70843 6.25114 5.39463C6.25068 5.08083 6.17957 4.77117 6.04309 4.4886C5.90661 4.20604 5.70827 3.95783 5.46276 3.76239C5.21726 3.56694 4.9309 3.42928 4.62493 3.35962C4.31896 3.28996 4.00123 3.29008 3.69532 3.35998C3.3894 3.42988 3.10315 3.56775 2.8578 3.76338C2.61244 3.95901 2.41429 4.20738 2.27802 4.49004C2.14176 4.77271 2.07089 5.08244 2.07067 5.39623C2.07067 5.45975 2.07374 5.52223 2.07937 5.58421H0.235498L0.234985 0.46284Z" fill="white"/>
                                </svg>
                            </div>
                            <span>
                            MUSCLE
                            CAR
                            <br> $ {{ format(games[3].price) }}
                        </span>
                        </div>
                        <div class="icon-box"    :class="{ selected: selectedGameId === games[4].id }"
                             @click="selectPrize(games[4].id)">
                            <div class="icon-box-2">
                                <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M15.2639 3.59302L10.7953 6.46131L11.2483 6.70933L15.2239 4.1574L21.9672 7.97707L18.0994 10.4597L18.2878 10.5629V10.8776L21.3173 8.93291L21.9532 9.29311L18.2877 11.6458V12.1846L21.258 10.278L21.9532 10.6718L18.2877 13.0245V13.5633L21.258 11.6567L21.9532 12.0506L18.2877 14.4033V14.942L22.8848 11.9912L21.7438 11.3449L22.8848 10.6125L21.7438 9.96623L22.8847 9.23383L21.8031 8.6211L22.8988 7.91774L15.2639 3.59302ZM16.6916 5.64908C15.7248 6.13419 14.437 6.21627 13.5303 5.85051L11.7578 6.98824L17.5898 10.1808L19.2709 9.10175C18.6087 8.57896 18.6638 7.7989 19.4061 7.18677L16.6916 5.64908ZM10.6903 7.34688L7.44173 9.46517L13.6738 13.0528L13.7349 13.0137C13.8498 12.9397 14.012 12.8349 14.2056 12.7098C14.5926 12.4597 15.1046 12.128 15.6153 11.7971C16.3506 11.3205 16.7296 11.0747 17.082 10.8461L10.6903 7.34688ZM15.9966 7.40065H15.9968C16.1438 7.40154 16.2785 7.43305 16.3791 7.49003C16.4377 7.52319 16.4831 7.5641 16.5128 7.61042C16.5425 7.65673 16.5559 7.70755 16.5522 7.75996C16.5484 7.81238 16.5277 7.86536 16.4912 7.91589C16.4546 7.96642 16.403 8.01351 16.3392 8.05446C16.2754 8.09541 16.2007 8.12943 16.1193 8.15457C16.038 8.17971 15.9516 8.19549 15.865 8.20099C15.7785 8.2065 15.6936 8.20163 15.6151 8.18666C15.5366 8.17169 15.466 8.14691 15.4075 8.11374C15.2893 8.04677 15.227 7.94969 15.2345 7.84385C15.242 7.73802 15.3186 7.6321 15.4475 7.54941C15.5206 7.50243 15.608 7.46465 15.7031 7.43889C15.7982 7.41314 15.8986 7.40006 15.9966 7.40065ZM5.95883 9.56586L1.11485 12.675L2.19651 13.2877L1.10083 13.9911L2.24182 14.6374L1.10083 15.3698L2.24182 16.0161L1.10083 16.7485L8.73571 21.0733L13.3453 18.1143V17.5757L8.77574 20.5088L2.03245 16.6891L2.68755 16.2686L8.73571 19.6945L13.3453 16.7357V16.1971L8.77574 19.1301L2.03245 15.3104L2.68755 14.8899L8.73571 18.3158L13.3453 15.357V14.8184L8.77574 17.7515L2.03245 13.9318L2.64228 13.5402L8.74982 16.9998L13.3453 14.05V13.8179L13.0934 13.6729L8.78966 16.4353L2.04656 12.6157L6.40134 9.82045L5.95878 9.56572L5.95883 9.56586ZM6.89908 10.1072L4.74283 11.4912C5.40506 12.0139 5.34991 12.7939 4.60763 13.4062L7.32215 14.9438C8.28893 14.4587 9.57661 14.3767 10.4833 14.7424L12.5957 13.3865L6.89899 10.1072L6.89908 10.1072ZM17.4605 11.5865C17.0909 11.8263 16.7648 12.0379 16.0652 12.4913C15.5952 12.796 15.1251 13.1004 14.6548 13.4046C14.461 13.5298 14.2984 13.6348 14.1824 13.7094C14.1783 13.7121 14.1766 13.7131 14.1726 13.7157V17.6644L17.4606 15.4545L17.4605 11.5865ZM8.22385 12.3898C8.37084 12.3908 8.5056 12.4223 8.60621 12.4793C8.72444 12.5463 8.78665 12.6434 8.77915 12.7492C8.77166 12.855 8.69506 12.961 8.56623 13.0437C8.43739 13.1263 8.26687 13.179 8.09219 13.1902C7.9175 13.2013 7.75294 13.1699 7.6347 13.1029C7.51647 13.036 7.45425 12.9389 7.46175 12.8331C7.46925 12.7272 7.54584 12.6213 7.67468 12.5386C7.74785 12.4916 7.83524 12.4539 7.93034 12.4281C8.02543 12.4024 8.12577 12.3893 8.22385 12.3899V12.3898Z" fill="white"/>
                                </svg>
                            </div>
                            <span>
                            RACING CAR<br>
                            $ {{ format(games[4].price) }}
                        </span>
                        </div>
                        -->
                    </div>

                </div>
                <div class="w-100 justify-content-between row" style="z-index:1;">
                    <div class="col-3 d-flex gap-4">
                        <img style="width:100px; height:100px" src="/assets/imgs/radar-cash.png">
                    </div>
                    <div class="col-6 d-flex flex-column gap-4 align-items-center">
                        <div class="d-flex justify-content-center">
                            <div class="d-flex justify-content-center gap-1">

                        </div>
                        </div>
                        <button
                            id="scan"
                            class="btn btn-custom mb-3"
                            :disabled="!canScan"
                            :style="buttonStyle"
                            @click="startScan"
                        >
                            {{ buttonText }}
                        </button>
                    </div>
                    <div class="col-3 d-flex justify-content-end gap-4" id="location">
                    <a href="https://www.google.com/maps?q=33.8938,35.5018" target="_blank">
                        <img style="width:100px; height:100px" src="/assets/imgs/my-location.png">
                        </a>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue'
import axios from 'axios'
import { reactive } from 'vue'

const activeOverlay = ref(null)



const props = defineProps({
    games:          { type: Array,  default: () => [] },
    selectedGameId: { type: Number, default: null },
    wallet_balance:  Number,
})
const walletBalance = ref(props.wallet_balance)

const prizes          = ref(props.games)
const selectedGameId  = ref(props.selectedGameId ?? props.games[0]?.id)
const loading         = ref(true)

const format = cents =>
    cents.toLocaleString('en-US', {
        style:                 'currency',
        currency:              'USD',
        maximumFractionDigits: 0,
    })

async function selectPrize(id) {
    selectedGameId.value = id
    try { await axios.post('/me/game', { game_id: id }) }
    catch {}
}
const radarOnline = ref(true);

async function fetchRadarStatus() {
    try {
        const { data } = await axios.get('/radar/status');
        radarOnline.value = !!data.online;
    } catch { /* keep old value */ }
}
onMounted(() => {
        const video = document.getElementById('myVideo');
        video?.play().catch((e) => {
            console.warn('Autoplay failed:', e);
        });
    setTimeout(() => (loading.value = false), 5000)
    fetchRadarStatus();
    setInterval(fetchRadarStatus, 5_000);
})
const canScan = computed(() => radarOnline.value && !scanning.value);

const originalColors  = [
    '#4AEBD5','#7BE9DD','#81D6C1',
    '#E97E7F','#E77E7F','#E95E72',
    '#E25669','#E45A73',
]

const visibleCount    = ref(0)
const scanning        = ref(false)
const detectionStatus = ref('idle')

const currentProgress = computed(() => {
    const g = prizes.value.find(p => p.id === selectedGameId.value)
    return g?.progress ?? { radar_level: 0 }
})
const buttonText = computed(() => {
    if (scanning.value)                      return 'Scanning…'
    if (detectionStatus.value === 'found')     return 'Antenna detected'
    if (detectionStatus.value === 'not-found') return 'Antenna not detected'
    return 'Scan'
})
function setGameProgress(gameId, progress) {
    const idx = prizes.value.findIndex(g => g.id === gameId)
    if (idx !== -1) prizes.value[idx].progress = progress
}

const buttonStyle = computed(() => {
    return detectionStatus.value === 'not-found'
        ? { backgroundColor: '#E25669', color: '#fff' }
        : {}
})


function barColor(idx) {
    if (detectionStatus.value === 'found')     return '#5DB0A1'
    if (detectionStatus.value === 'not-found') return '#E25669'
    return originalColors[idx]
}


function sleep(ms) {
    return new Promise(resolve => setTimeout(resolve, ms))
}

async function startScan() {
    if (scanning.value) return


    scanning.value        = true
    detectionStatus.value = 'searching'
    visibleCount.value    = 0


    let found = false
    let dat;
    try {
        const { data } = await axios.post('/scan/'+selectedGameId.value)
        found = !!data.antenna_detected
        dat = data;
        walletBalance.value = data.wallet

    } catch {
        found = false
    }


    const total       = originalColors.length
    const totalMs     = 8000
    const interval    = totalMs / total
    const bounceCount = Math.floor(Math.random()*2) + 1
    const bounceSet   = new Set()
    while (bounceSet.size < bounceCount) {
        bounceSet.add(Math.floor(Math.random()*total) + 1)
    }


    for (let i = 1; i <= total; i++) {
        visibleCount.value = i
        await sleep(interval)

        if (bounceSet.has(i)) {
            visibleCount.value = Math.max(0, i - 1)
            await sleep(interval)
            visibleCount.value = i
        }
    }


    detectionStatus.value = found ? 'found' : 'not-found'
    scanning.value        = false
    setGameProgress(selectedGameId.value, dat.progress)

    await sleep(2000)
    detectionStatus.value = 'idle'
    visibleCount.value    = 0
}


const currentPage = ref('settings');

const musicOn = ref(true);
const toggleMusic = () => {
  musicOn.value = !musicOn.value;
};

const newPassword = ref('');
const confirmPassword = ref('');



const images = reactive([
  { name: 'mobile', baseSrc: '/assets/imgs/mobile.png', detectedSrc: '/assets/imgs/mobile-detected.png', isSelected: true },
  { name: 'bike-and-electronics', baseSrc: '/assets/imgs/bike-and-electronics.png', detectedSrc: '/assets/imgs/bike-and-electronics-detected.png', isSelected: false },
  { name: 'suv', baseSrc: '/assets/imgs/suv.png', detectedSrc: '/assets/imgs/suv-detected.png', isSelected: false },
  { name: 'super-car', baseSrc: '/assets/imgs/super-car.png', detectedSrc: '/assets/imgs/super-car-detected.png', isSelected: false },
  { name: 'muscle-car', baseSrc: '/assets/imgs/muscle-car.png', detectedSrc: '/assets/imgs/muscle-car-detected.png', isSelected: false },
])

function selectImage(selectedIndex) {
  images.forEach((img, idx) => {
    img.isSelected = idx === selectedIndex
  })
}


</script>


<style scoped>
.icon-box.selected .icon-box-2 {
    position: relative;
}
.icon-box.selected .icon-box-2::after{
    content:'';
    position:absolute; inset:-4px;
    border:3px solid #11c26d;
    border-radius:50%;
}
.loading-bar {
    width: 0;
    animation: grow 5s forwards;
}
@keyframes grow {
    to { width: 100%; }
}








.circle-loader {

    position: absolute;
    top: 50%;
    left: 50%;
    margin-top: -185px;
    margin-left: -185px;
    width: 370px;
    height: 370px;
}

.circle-loader-svg {
  transform: rotate(-90deg);
  width: 100%;
  height: 100%;
}

.circle-loader .circle-bg {
  fill: none;
  stroke: rgba(255,255,255,0.35);
  stroke-width: 1;
}

.circle-loader .circle-progress {
  fill: none;
  stroke: #85f9d3;
  stroke-width: 4;
  stroke-linecap: round;
  stroke-dasharray: 283;         /* 2πr where r = 45 */
  stroke-dashoffset: 283;
  animation: circle-progress-anim 5s linear forwards;
}

@keyframes circle-progress-anim {
  to {
    stroke-dashoffset: 0;
  }
}













































.bar-container {
    display: flex;
    flex-direction: column;
    gap: 4px;
    min-height: calc(8px * 8 + 4px * 7);
}
.antenna svg {
    width: 24px;
    height: 24px;
    object-fit: contain;
    fill: currentColor;
}
.antenna svg {
    color: rgba(255,255,255,0.5);
}


.antenna.active svg {
    color: #6ed1bf;
}
</style>
