<template>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bungee&display=swap" rel="stylesheet">
<!--     <link href="https://db.onlinewebfonts.com/c/85040c569cc6193905af9f9ee765baf4?family=GE+Flow" rel="stylesheet">-->


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
            <template>
  <div>
    <h1>Hello from Vue!</h1>
  </div>
</template>

        <section
            v-show="!loading"
            id="game"
            class="w-100"
        >
        <!-- Corrected: Added closing </section> tag for the previous section -->


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
                       <!--
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

<!--
                  <img class="selectable" style="width:100px;" src="/assets/imgs/mobile.png" />

                    <img class="selectable" style="width:100px;" src="/assets/imgs/bike-and-electronics.png" />
                    <img class="selectable" style="width:100px;" src="/assets/imgs/suv.png" />
                    <img class="selectable" style="width:100px;" src="/assets/imgs/super-car.png" />
                    <img class="selectable" style="width:100px;" src="/assets/imgs/muscle-car.png" /> -->



<div id="image-selector">
  <img class="selectable" src="/assets/imgs/mobile.png" data-detected="/assets/imgs/mobile-detected.png" />
  <img class="selectable" src="/assets/imgs/be.png" data-detected="/assets/imgs/be-detected.png" />
  <img class="selectable" src="/assets/imgs/suv.png" data-detected="/assets/imgs/suv-detected.png" />
  <img class="selectable" src="/assets/imgs/super-car.png" data-detected="/assets/imgs/super-car-detected.png" />
  <img class="selectable" src="/assets/imgs/muscle-car.png" data-detected="/assets/imgs/muscle-car-detected.png" />
</div>


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


</script>


<script>
export default {
  mounted() {
          const video = document.getElementById('myVideo');
          video?.play().catch((e) => {
              console.warn('Autoplay failed:', e);
          });
    console.log("Vue mounted — now safe to run DOM logic.");

    const images = document.querySelectorAll('#image-selector .selectable');

    images.forEach((img) => {
      img.style.width = '100px';
      img.style.cursor = 'pointer';

      img.addEventListener('click', () => {
        images.forEach((otherImg) => {
          otherImg.style.border = 'none';
          otherImg.src = otherImg.getAttribute('src').replace('-detected', '');
        });

        img.style.border = '3px solid #4CAF50';
        img.src = img.dataset.detected;
      });
    });
  }
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
