<template>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bungee&display=swap" rel="stylesheet">
<!--    <link href="https://db.onlinewebfonts.com/c/85040c569cc6193905af9f9ee765baf4?family=GE+Flow" rel="stylesheet">-->

    <div>
        <div v-if="activeOverlay" class="overlay" @click.self="activeOverlay = null">

             <div class="overlay-content">
                <template v-if="activeOverlay === 'help'">
                    <div class="help-container">
                        <h1 class="overlay-title">RADAR LEB</h1>
                        <p dir="rtl">
                            هي لعبة ممتعة تجمع بين الاستراتيجيةوالحظ. الهدف الرئيسي من اللعبة هو قيام اللاعبين بمسح من عدة مناطق على طول الأراضي اللبنانية وجمع الهوائيات باستخدام واجهة رادار. كل عملية مسح ناجحة تضيف إلى عداد الهوائيات الخاص باللاعب. عند اكتشاف ستة هوائيات نشطة, يفوز اللاعب بعد اختياره من مجموعة متنوعة من الجوائز القيمة, بما في ذلك الهواتف المحموله, الإلكترونيات, الدراجات النارية, سيارات الدفع الرباعي والسيارات الخارقة.
                        </p>
                        <h2 class="overlay-subtitle" dir="rtl">كيفية المشاركة ولعب <span class="ltr-inline">RADAR LEB</span></h2>
                        <ol dir="rtl">
                            <li>قم بتحميل تطبيق WISH OR OMT OR SUYOOLعلى هاتفك او خدمة DOOR TO DOOR PICK UP CASH</li>
                            <li>اشحن محفظتك بالدولار بالمبلغ الأدنى المذكور في النص أدناه, ثم قم بتحويل المبلغ إلى الرقم 71484833 وأكد التحويل عبر خدمة الواتساب مع إضافة اسمك الكامل ورقم الهاتف ومبلغ الحد الأدنى المطلوب لكل جائزة ب ال NOTE OR REASON</li>
                            <li>تحتاج عملية تشريج الرادارات إلى محفظتك ل٢٤ ساعة كحد أقصى</li>
                            <li>اضغط على الجائزة التي تختارها</li>
                            <li>اضغط على زر المسح الضوئي SCAN الذي يساعدك على اكتشاف الهوائيات الموزعة على كافة المناطق اللبنانية</li>
                            <li>بمجرد مسح واكتشاف ستة هوائيات نشطة, يفوز اللاعب بالجائزة المختارة</li>
                        </ol>
                        <p dir="rtl">
                            ملاحظة: يجب استخدام زر المسح الضوئي في مواقع مختلفة داخل الأراضي اللبنانية لضمان اكتشاف الهوائيات النشطة, بعد اعلان ربح كل جائزة خيار زر RADAR ONLINE سيتحول إلى RADAR ONLINE ليتم توقيف زر ال للمشتركين لوقت قصير للتمكن من التحضير للجائزة التالية, بعد عملية تشريج الرادارات إلى محفظتك لا يسمح للمشترك المطالبة بإعادة المبلغ نقدا
                            يحق فقط لرابح الجائزة أن يستلمها
                        </p>

                         <button class="a-btn a-btn-default" @click="activeOverlay = null" >
  Back
</button>

                    </div>
                </template>

                <template v-else-if="activeOverlay === 'winners'">
                    <div class="winners-container">
                        <h1 class="overlay-title">WINNERS</h1>
                        <div class="winner-card">
                            <div class="winner-icon">
                                <img src="/assets/imgs/winner.png" alt="Winner Icon">
                            </div>
                            <div class="winner-details">
                                <span class="winner-name">USER.NAME01</span>
                                <span class="winner-prize">WINNER DRAW 1 - BIKE</span>
                            </div>
                        </div>
                        <div class="winner-card">
                            <div class="winner-icon">
                                <img src="/assets/imgs/winner.png" alt="Winner Icon">
                            </div>
                            <div class="winner-details">
                                <span class="winner-name">USER.NAME02</span>
                                <span class="winner-prize">WINNER DRAW 1 - SUV</span>
                            </div>
                        </div>
                        <div class="winner-card">
                             <div class="winner-icon">
                                <img src="/assets/imgs/winner.png" alt="Winner Icon">
                            </div>
                            <div class="winner-details">
                                <span class="winner-name">USER.NAME03</span>
                                <span class="winner-prize">WINNER DRAW 1 - CASH</span>
                            </div>
                        </div>
                    </div>
                </template>

                <template v-else-if="activeOverlay === 'settings'">
                    <div class="settings-container">
                        <h1 class="overlay-title">SETTINGS</h1>
                        <div v-if="showSuccessMessage" class="success-message" style="background-color: #5DB0A1; color: white; padding: 15px; border-radius: 10px; margin-bottom: 20px; text-align: center;">
                            Password changed successfully
                        </div>
                        <div v-if="currentPage === 'settings'" class="settings-menu">
                            <!-- Button class updated to reflect musicOn state -->
                            <button :class="audioEnabled ? 'a-btn a-btn-music-on' : 'a-btn a-btn-music-off'" @click="toggleMusic">
                                Music
                            </button>

                            <button class="a-btn a-btn-default" @click="currentPage = 'password'">
                                Change Password
                            </button>
                        </div>

                        <div v-else-if="currentPage === 'password'" class="settings-menu">
                            <!-- Step A: Verify old password -->
                            <div v-if="!oldPasswordVerified">
                                <h2 class="overlay-subtitle">Change Your Password</h2>
                                <input 
                                    type="password" 
                                    placeholder="Enter old password" 
                                    v-model="oldPassword" 
                                    class="a-input"
                                    :class="{ 'error': passwordError }"
                                />
                                <div v-if="passwordError" class="error-message" style="color: #ef4444; margin-top: 10px; font-size: 0.9em; display: flex; align-items: flex-start; gap: 8px;">
                                    <span style="font-size: 16px; flex-shrink: 0; margin-top: 2px;">⚠️</span>
                                    <span>{{ passwordError }}</span>
                                </div>
                                <div v-if="wrongAttempts >= 3" class="mt-3">
                                    <Link
                                        as="button"
                                        type="button"
                                        href="/forgot-password"
                                        class="a-btn a-btn-default"
                                        style="width: 100%;"
                                    >
                                        Forgot Password?
                                    </Link>
                                </div>
                                <button 
                                    class="a-btn a-btn-music-on mt-3" 
                                    @click="verifyOldPassword"
                                    :disabled="!oldPassword || verifyingPassword"
                                    style="width: 100%;"
                                >
                                    {{ verifyingPassword ? 'Verifying...' : 'Continue' }}
                                </button>
                                <button 
                                    class="a-btn a-btn-default mt-2" 
                                    @click="resetPasswordFlow"
                                    style="width: 100%;"
                                >
                                    Back
                                </button>
                            </div>

                            <!-- Step B: Enter new password -->
                            <div v-else>
                                <h2 class="overlay-subtitle">Enter New Password</h2>
                                <input 
                                    type="password" 
                                    placeholder="Enter new password" 
                                    v-model="newPassword" 
                                    class="a-input"
                                    :class="{ 'error': newPasswordError }"
                                />
                                <div v-if="newPasswordError" class="error-message" style="color: #ef4444; margin-top: 10px; font-size: 0.9em; display: flex; align-items: flex-start; gap: 8px;">
                                    <span style="font-size: 16px; flex-shrink: 0; margin-top: 2px;">⚠️</span>
                                    <span>{{ newPasswordError }}</span>
                                </div>
                                <input 
                                    type="password" 
                                    placeholder="Confirm new password" 
                                    v-model="confirmPassword" 
                                    class="a-input mt-3"
                                    :class="{ 'error': confirmPasswordError }"
                                />
                                <div v-if="confirmPasswordError" class="error-message" style="color: #ef4444; margin-top: 10px; font-size: 0.9em; display: flex; align-items: flex-start; gap: 8px;">
                                    <span style="font-size: 16px; flex-shrink: 0; margin-top: 2px;">⚠️</span>
                                    <span>{{ confirmPasswordError }}</span>
                                </div>
                                <button 
                                    class="a-btn a-btn-music-on mt-3" 
                                    @click="updatePassword"
                                    :disabled="!newPassword || !confirmPassword || updatingPassword"
                                    style="width: 100%;"
                                >
                                    {{ updatingPassword ? 'Updating...' : 'Done' }}
                                </button>
                                <button 
                                    class="a-btn a-btn-default mt-2" 
                                    @click="resetPasswordFlow"
                                    style="width: 100%;"
                                >
                                    Back
                                </button>
                            </div>
                        </div>
                    </div>
                </template>
            </div>
        </div>


        <section v-if="loading" id="loading-game">
            <div class="loader-content">
                <div class="loader-circle-container">
                    <img src="/assets/imgs/Flag_of_Lebanon.png" class="flag-center" alt="Lebanon Flag" />
                    <svg class="loader-svg" viewBox="0 0 100 100">
                        <!-- Add this <defs> block here -->
                        <defs>
                            <linearGradient id="loaderGradient" x1="0%" y1="0%" x2="100%" y2="0%">
                                <stop offset="0%" stop-color="#48fdd0" />
                                <stop offset="100%" stop-color="#62c3ff" />
                            </linearGradient>
                        </defs>
                        <circle class="loader-bg" cx="50" cy="50" r="45"></circle>
                        <circle class="loader-progress" cx="50" cy="50" r="45"></circle>
                    </svg>

                </div>
            </div>
        </section>

        <section v-show="!loading" id="game">
            <video autoplay
                   :muted="true"
                   loop playsinline id="myVideo">
                <source src="/assets/imgs/vid.webm" type="video/mp4">
                Your browser does not support HTML5 video.
            </video>

            <div class="game-content-wrapper">
                <div class="bar">
                    <div class="bar-left">
                        <img src="assets/imgs/logo.png" class="logo-nav">
                    </div>
                    <div class="bar-center">
                        <div :class="['icon-box-2', radarOnline ? 'green' : 'red']">
                            <svg></svg>
                        </div>
                    </div>
                    <div class="bar-right">
                        <img src="/assets/imgs/winners-button.png" class="menu-item" @click="activeOverlay = 'winners'" />
                        <img src="/assets/imgs/help-button.png" class="menu-item" @click="activeOverlay = 'help'" />
                        <img src="/assets/imgs/settings-button.png" class="menu-item" @click="activeOverlay = 'settings'" />
                        <button class="btn-logout" @click="handleLogout" title="Logout">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                                <polyline points="16 17 21 12 16 7"></polyline>
                                <line x1="21" y1="12" x2="9" y2="12"></line>
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="radar-row">
                    <div class="col-3 antenna-detection-col">
                        <div class="icon-box">
                              <img :src="antennaIconSrc" class="an" style="width: 100px;
  margin-bottom: 0px;
  max-width: 100%;
"/>
                              <div class="antenna-label">ANTENNA DETECTION</div>
                        </div>
                        <div class="bar-container">
                            <div class="fill-bar" :style="{ height: (visibleCount / originalColors.length) * 100 + '%' }"></div>
                        </div>
                    </div>

                    <div class="col-6 radar-col" style="padding:0px;">
                        <div class="radar">
                            <video autoplay muted loop playsinline id="myVideo2" ref="radarVideo">


                                <source src="/assets/imgs/radar.webm" type="video/webm" />
                                Your browser does not support HTML5 video.
                            </video>
                        </div>
                    </div>

                    <div class="col-3 prize-selection-col" style="padding:0 !important;">
                        <div id="image-selector" class="prize-selector">
                            <div class="prize-item">
                                <img class="selectable" src="/assets/imgs/mobile1.png" data-detected="/assets/imgs/mobile-detected1.png" />
                                <div class="prize-label">MOBILE</div>
                                <div class="prize-price">1.500$</div>
                            </div>
                            <div class="prize-item">
                                <img class="selectable" src="/assets/imgs/be1.png" data-detected="/assets/imgs/be-detected1.png" />
                                <div class="prize-label">BIKE / ELECTRONICS</div>
                                <div class="prize-price">15.000$</div>
                            </div>
                            <div class="prize-item">
                                <img class="selectable" src="/assets/imgs/suv1.png" data-detected="/assets/imgs/suv-detected1.png" />
                                <div class="prize-label">SUV</div>
                                <div class="prize-price">50.000$</div>
                            </div>
                            <div class="prize-item">
                                <img class="selectable" src="/assets/imgs/muscle-car1.png" data-detected="/assets/imgs/muscle-car-detected1.png" />
                                <div class="prize-label">MUSCLE CAR</div>
                                <div class="prize-price">150.000$</div>
                            </div>
                            <div class="prize-item">
                                <img class="selectable" src="/assets/imgs/super-car1.png" data-detected="/assets/imgs/super-car-detected1.png" />
                                <div class="prize-label">SUPER CAR</div>
                                <div class="prize-price">200.000$</div>
                            </div>
                        </div>
                    </div>
                </div>







                <div class="antenna-container">
                    <div v-for="n in 6" :key="n">
                        <img
                            :src="(n === 1 ? currentProgress.radar_level >= 2 : n <= currentProgress.radar_level) ? '/assets/imgs/enable1.png' : '/assets/imgs/enable.png'"
                            class="antenna-icon"
                        />
                    </div>
                </div>






                <div class="button-row">
                     <div class="col-3 cash-balance-container"> <img style="width:100px; height:100px" src="/assets/imgs/radar-cash.png">
            <span class="wallet-balance-display">RADAR CASH {{ walletBalance }}</span> </div>
                    <div class="col-6">





                        <button id="scan" class="btn btn-custom" :disabled="!canScan" :style="buttonStyle" @click="startScan">
                            {{ buttonText }}
                        </button>
                    </div>
                    <div class="col-3 location-container">
                        <a :href="locationUrl" target="_blank" @click="getUserLocation" style="display: flex; justify-content: center; align-items: center;">
                            <img style="width:100px; height:auto; object-fit: contain;" src="/assets/imgs/my-location.png">
                        </a>
                        <span class="location-label">MY LOCATION</span>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <audio id="scanSound" src="/assets/imgs/audio/radar.mp3" preload="auto"></audio>
    <audio id="scanSound2" src="/assets/imgs/audio/radar2.mp3" preload="auto"></audio>
    <audio id="hornSound" src="/assets/imgs/horn.mp3" preload="auto"></audio>
    <audio id="clickSound" src="/assets/imgs/click.mp3" preload="auto"></audio>

</template>
<script setup>
import { ref, onMounted, computed, watch, nextTick, onUnmounted } from 'vue';
import axios from 'axios';
import { router, Link } from '@inertiajs/vue3';

const activeOverlay = ref(null);

const props = defineProps({
    games: { type: Array, default: () => [] },
    selectedGameId: { type: Number, default: null },
    wallet_balance: Number,
});

const prizes = ref(props.games);
const selectedGameId = ref(props.selectedGameId ?? (prizes.value.length > 0 ? prizes.value[0]?.id : null));
const walletBalance = ref(props.wallet_balance);
const loading = ref(true);

const radarOnline = ref(true);
const scanning = ref(false);
const detectionStatus = ref('idle');
const visibleCount = ref(0);
const antennaIconSrc = ref('/assets/imgs/an.png');

// Ref for the radar video element
const radarVideo = ref(null);

const originalColors = [
    '#4AEBD5', '#7BE9DD', '#81D6C1',
    '#E97E7F', '#E77E7F', '#E95E72',
    '#E25669', '#E45A73',
];

const currentPage = ref('settings');
const audioEnabled = ref(true);
const oldPassword = ref('');
const newPassword = ref('');
const confirmPassword = ref('');
const oldPasswordVerified = ref(false);
const wrongAttempts = ref(0);
const passwordError = ref('');
const newPasswordError = ref('');
const confirmPasswordError = ref('');
const verifyingPassword = ref(false);
const updatingPassword = ref(false);
const showSuccessMessage = ref(false);
const help = ref(false);
const userLocation = ref({ lat: null, lng: null });
const locationUrl = ref('https://www.google.com/maps?q=33.8938,35.5018'); // Default fallback location

const canScan = computed(() => radarOnline.value && !scanning.value && selectedGameEnabled.value);

const buttonText = computed(() => {
    if (!selectedGameEnabled.value) return 'Coming soon';
    if (scanning.value) return 'Scanning…';
    if (detectionStatus.value === 'found') return 'Antenna detected';
    if (detectionStatus.value === 'not-found') return 'Antenna not detected';
    return 'Scan';
});

const buttonStyle = computed(() => {
    if (scanning.value) {
        return { backgroundColor: '#E25669', color: '#fff' }; // Red color
    } else if (detectionStatus.value === 'not-found') {
        return { backgroundColor: '#E25669', color: '#fff' };
    } else {
        return { backgroundColor: '#66afdb', color: '#fff' }; // Example default blue
    }
});

const selectedGameEnabled = computed(() => {
    const g = prizes.value.find(p => p.id == selectedGameId.value);
    return g ? !!g.is_enabled : true; // default true if missing
});
function sleep(ms) {
    return new Promise(resolve => setTimeout(resolve, ms));
}

async function selectPrize(id) {
    // Update UI immediately for instant visual feedback
    selectedGameId.value = id;
    updatePrizeSelectionUI();
    
    // Make API call in background (non-blocking) - don't wait for it
    axios.post('/me/game', { game_id: id }).catch(error => {
        console.error("Failed to select prize:", error);
    });
}
const currentProgress = computed(() => {
    const g = prizes.value.find(p => p.id == selectedGameId.value)

    return g?.progress ?? { radar_level: 0 }
})

function setGameProgress(gameId, progress) {
    const idx = prizes.value.findIndex(g => g.id === gameId);
    if (idx !== -1) {
        prizes.value[idx].progress = progress;
    }
}

const playClickSound = () => {
    if (!audioEnabled.value) return;
    const clickSound = document.getElementById('clickSound');
    if (clickSound) {
        clickSound.currentTime = 0;
        clickSound.play().catch(error => {
            console.warn("Autoplay for click sound prevented:", error);
        });
    }
};

function playScanSoundSequence() {
  if (!audioEnabled.value) return;

  const a1 = document.getElementById('scanSound');
  const a2 = document.getElementById('scanSound2');
  
  if (!a1 || !a2) return;

  // Reset both audio elements to prevent overlap
  [a1, a2].forEach(a => {
    a.loop = false;
    a.pause();
    a.currentTime = 0;
  });

  // When radar.mp3 ends, play radar2.mp3
  a1.addEventListener('ended', () => {
    a2.currentTime = 0;
    a2.play().catch(console.error);
  }, { once: true });

  // Start playing radar.mp3
  a1.play().catch(console.error);
}

async function startScan() {
    if (scanning.value) return;

    playScanSoundSequence();

    scanning.value = true;
    detectionStatus.value = 'searching';
    visibleCount.value = 0;
    antennaIconSrc.value = '/assets/imgs/an.png'; // Reset to default before scan

    if (radarVideo.value) {
        radarVideo.value.play();
        setTimeout(() => {
            radarVideo.value.pause();
            radarVideo.value.currentTime = 0;
        }, 16000);
    }

    let found = false;
    let dat;
    try {
        const { data } = await axios.post('/scan/' + selectedGameId.value);
        found = !!data.antenna_detected;
        dat = data;
        walletBalance.value = data.wallet;
    } catch {
        found = false;
    }

    const total = originalColors.length;
    const totalMs = 16000;
    const interval = totalMs / total;

    for (let i = 1; i <= total; i++) {
        visibleCount.value = i;
        await sleep(interval);
    }

    detectionStatus.value = found ? 'found' : 'not-found';
    scanning.value = false;
    if (dat) {
        setGameProgress(selectedGameId.value, dat.progress);
    }

    if (found) {
        antennaIconSrc.value = '/assets/imgs/an2.png';
    } else {
        antennaIconSrc.value = '/assets/imgs/an3.png';
    }

    await sleep(2000);
    detectionStatus.value = 'idle';
    visibleCount.value = 0;
    antennaIconSrc.value = '/assets/imgs/an.png';
}
async function fetchRadarStatus() {
    try {
        const { data } = await axios.get('/radar/status');
        radarOnline.value = !!data.online;
    } catch {  }
}
const toggleMusic = () => {
    audioEnabled.value = !audioEnabled.value;
    const allAudioElements = document.querySelectorAll('audio');
    allAudioElements.forEach(audioEl => {
        if (audioEnabled.value) {
        } else {
            audioEl.pause();
            audioEl.currentTime = 0;
        }
    });

    if (!audioEnabled.value && hornInterval) {
        clearInterval(hornInterval);
        hornInterval = null; // Clear the interval ID
    } else if (audioEnabled.value && !hornInterval) {
        const playHornSound = () => {
            const hornSound = document.getElementById('hornSound');
            if (hornSound && audioEnabled.value) {
                hornSound.play().catch(error => {
                    console.warn("Autoplay for horn sound prevented (re-enabled):", error);
                });
            }
        };
        playHornSound();
        hornInterval = setInterval(playHornSound, 180000);
    }
};

const handleLogout = () => {
    router.post('/logout');
};

const resetPasswordFlow = () => {
    oldPassword.value = '';
    newPassword.value = '';
    confirmPassword.value = '';
    oldPasswordVerified.value = false;
    wrongAttempts.value = 0;
    passwordError.value = '';
    newPasswordError.value = '';
    confirmPasswordError.value = '';
    currentPage.value = 'settings';
};

const verifyOldPassword = async () => {
    if (!oldPassword.value) {
        passwordError.value = 'Please enter your old password';
        return;
    }

    verifyingPassword.value = true;
    passwordError.value = '';

    try {
        const response = await axios.post('/settings/password/verify', {
            old_password: oldPassword.value
        });

        if (response.data.verified) {
            oldPasswordVerified.value = true;
            wrongAttempts.value = 0;
            passwordError.value = '';
        } else {
            wrongAttempts.value++;
            if (wrongAttempts.value >= 3) {
                passwordError.value = 'Too many incorrect attempts. Please use "Forgot Password?" to reset.';
            } else {
                passwordError.value = `Incorrect password. ${3 - wrongAttempts.value} attempts remaining.`;
            }
        }
    } catch (error) {
        if (error.response?.data?.message) {
            passwordError.value = error.response.data.message;
        } else {
            passwordError.value = 'An error occurred. Please try again.';
        }
        wrongAttempts.value++;
        if (wrongAttempts.value >= 3) {
            passwordError.value = 'Too many incorrect attempts. Please use "Forgot Password?" to reset.';
        }
    } finally {
        verifyingPassword.value = false;
    }
};

const updatePassword = async () => {
    // Clear previous errors
    newPasswordError.value = '';
    confirmPasswordError.value = '';

    // Validation
    if (!newPassword.value) {
        newPasswordError.value = 'Please enter a new password';
        return;
    }

    if (newPassword.value.length < 8) {
        newPasswordError.value = 'Password must be at least 8 characters';
        return;
    }

    if (!confirmPassword.value) {
        confirmPasswordError.value = 'Please confirm your new password';
        return;
    }

    if (newPassword.value !== confirmPassword.value) {
        confirmPasswordError.value = 'Passwords do not match';
        return;
    }

    updatingPassword.value = true;

    try {
        const response = await axios.post('/settings/password', {
            old_password: oldPassword.value,
            new_password: newPassword.value,
            new_password_confirmation: confirmPassword.value
        });

        // Show success message
        showSuccessMessage.value = true;
        
        // Reset form and return to settings after 2 seconds
        setTimeout(() => {
            resetPasswordFlow();
            showSuccessMessage.value = false;
        }, 2000);
    } catch (error) {
        if (error.response?.data?.errors) {
            const errors = error.response.data.errors;
            if (errors.new_password) {
                newPasswordError.value = errors.new_password[0];
            }
            if (errors.new_password_confirmation) {
                confirmPasswordError.value = errors.new_password_confirmation[0];
            }
            if (errors.old_password) {
                passwordError.value = errors.old_password[0];
            }
        } else if (error.response?.data?.message) {
            passwordError.value = error.response.data.message;
        } else {
            passwordError.value = 'An error occurred. Please try again.';
        }
    } finally {
        updatingPassword.value = false;
    }
};

const getUserLocation = (event) => {
    // If we already have the location, just open the link normally
    if (userLocation.value.lat !== null && userLocation.value.lng !== null) {
        playClickSound();
        return; // Let the link open normally
    }

    // Prevent default link behavior to get location first
    event.preventDefault();
    playClickSound();

    if (!navigator.geolocation) {
        alert('Geolocation is not supported by your browser. Using default location.');
        window.open(locationUrl.value, '_blank');
        return;
    }

    navigator.geolocation.getCurrentPosition(
        (position) => {
            userLocation.value = {
                lat: position.coords.latitude,
                lng: position.coords.longitude
            };
            locationUrl.value = `https://www.google.com/maps?q=${userLocation.value.lat},${userLocation.value.lng}`;
            
            // Open the link with the actual location
            window.open(locationUrl.value, '_blank');
        },
        (error) => {
            console.error('Error getting location:', error);
            // Open with default location if user denies or error occurs
            window.open(locationUrl.value, '_blank');
        },
        {
            enableHighAccuracy: true,
            timeout: 10000,
            maximumAge: 60000 // Cache for 1 minute
        }
    );
};


const updatePrizeSelectionUI = () => {
    const prizeItems = document.querySelectorAll('#image-selector .prize-item');
    prizeItems.forEach((item, index) => {
        const img = item.querySelector('.selectable');
        if (!img) return;

        // Ensure original source is stored - get from HTML attribute first
        if (!img.dataset.originalSrc) {
            const originalSrc = img.getAttribute('src');
            if (originalSrc) {
                img.dataset.originalSrc = originalSrc;
            }
        }

        const prizeId = prizes.value[index]?.id;
        const originalSrc = img.dataset.originalSrc;

        // Check if this image's prize is selected
        if (prizeId !== undefined && prizeId === selectedGameId.value) {
            // Switch to detected version
            const detectedSrc = img.dataset.detected;
            if (detectedSrc) {
                img.src = detectedSrc;
            }
        } else {
            // Always switch back to original for non-selected images
            img.style.border = 'none';
            if (originalSrc) {
                img.src = originalSrc;
            }
        }
    });
};

let hornInterval = null;


onMounted(() => {
    fetchRadarStatus();
    setInterval(fetchRadarStatus, 5_000);

    // Scan audio sequence is handled by playScanSoundSequence() function
    
    // Add error listeners to DOM audio element for debugging
    const a2 = document.getElementById('scanSound2');
    if (a2) {
        a2.addEventListener('error', () => {
            console.error('scanSound2 DOM element error:', a2.error, a2.src, {
                readyState: a2.readyState,
                networkState: a2.networkState,
                duration: a2.duration
            });
        }, { once: false });
        
        a2.addEventListener('loadedmetadata', () => {
            console.log('scanSound2 loadedmetadata:', {
                src: a2.src,
                readyState: a2.readyState,
                duration: a2.duration,
                networkState: a2.networkState
            });
        }, { once: false });
        
        a2.addEventListener('canplaythrough', () => {
            console.log('scanSound2 canplaythrough:', {
                src: a2.src,
                readyState: a2.readyState,
                duration: a2.duration
            });
        }, { once: false });
        
        // Log initial state
        console.log('scanSound2 initial state:', {
            src: a2.src,
            readyState: a2.readyState,
            networkState: a2.networkState,
            duration: a2.duration
        });
    }

    const video = document.getElementById('myVideo');
        video?.play().catch((e) => {
            console.warn('Autoplay failed:', e);
        });
    setTimeout(() => {
        loading.value = false;
        if (radarVideo.value) {
            radarVideo.value.pause();
            radarVideo.value.currentTime = 0;
        }

        const playHornSound = () => {
            const hornSound = document.getElementById('hornSound');
            if (hornSound && audioEnabled.value) { // Check audioEnabled here
                hornSound.play().catch(error => {
                    console.warn("Autoplay for horn sound prevented:", error);
                });
            }
        };

        if (audioEnabled.value) {
            playHornSound();
            hornInterval = setInterval(playHornSound, 180000);
        }

    }, 2000);

    const prizeItems = document.querySelectorAll('#image-selector .prize-item');
    prizeItems.forEach((item, index) => {
        const img = item.querySelector('.selectable');
        if (!img) return;

        // Store original source from the initial src attribute before any changes
        if (!img.dataset.originalSrc) {
            const originalSrc = img.getAttribute('src');
            if (originalSrc) {
                img.dataset.originalSrc = originalSrc;
            }
        }
        
        const prizeId = prizes.value[index]?.id;
        
        // Preload detected images for instant switching
        const detectedSrc = img.dataset.detected;
        if (detectedSrc) {
            const preloadImg = new Image();
            preloadImg.src = detectedSrc;
        }
        
        // Attach click handler to the entire prize item
        item.addEventListener('click', () => {
            if (prizeId !== undefined) {
                selectPrize(prizeId);
                playClickSound();
            }
        });
    });

    const radarCashImg = document.querySelector('img[src="/assets/imgs/radar-cash.png"]');
    if (radarCashImg) {
        radarCashImg.addEventListener('click', playClickSound);
    }

    const myLocationImg = document.querySelector('img[src="/assets/imgs/my-location.png"]');
    if (myLocationImg) {
        myLocationImg.addEventListener('click', playClickSound);
    }

    const menuItems = document.querySelectorAll('.menu-item');
    menuItems.forEach(item => {
        item.addEventListener('click', playClickSound);
    });

    const backButton = document.querySelector('.help-container .a-btn-default');
    if (backButton) {
        backButton.addEventListener('click', playClickSound);
    }

      const settingsMenuButtons = document.querySelectorAll('.settings-menu .a-btn');
    settingsMenuButtons.forEach(button => {
        button.addEventListener('click', playClickSound);
    });


    updatePrizeSelectionUI();
});

onUnmounted(() => {
    if (hornInterval) {
        clearInterval(hornInterval);
    }
});

watch(selectedGameId, updatePrizeSelectionUI);
</script>

<style>

#loading-game {
    background-image: url("/assets/imgs/loading-bg.png");
    position: fixed;
    top: 0;
    left: 0;
    width: 100vw;
    height: 100vh;
    z-index: 1000;
    display: flex;
    justify-content: center;
    align-items: center;
    background-size: cover;
    background-position: center;
}

.loader-content {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    width: 100%;
    height: 100%;
    position: relative;
}

.loader-circle-container {
    position: relative;
    width: 500px; /* Adjust size as needed */
    height: 500px;
    display: flex;
    justify-content: center;
    align-items: center;
    margin-bottom: 20px;
}

.loader-svg {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    transform: rotate(-90deg);
}

.loader-bg {
    fill: none;
    stroke: rgba(255, 255, 255, 0.3); /* Lighter grey for background circle */
    stroke-width: 5;
}

.loader-progress {
    fill: none;
    stroke: url(#loaderGradient); /* Reference the gradient defined in SVG */
    stroke-width: 8;
    stroke-linecap: round;
    animation: load-progress 2s linear forwards; /* 2 seconds animation */
    stroke-dasharray: 282.7; /* 2 * PI * 45 (radius) */
    stroke-dashoffset: 282.7; /* Start fully hidden */
    filter: drop-shadow(0 0 5px rgba(0, 255, 255, 0.7)) drop-shadow(0 0 5px rgba(0, 255, 255, 0.5)); /* Neon glow effect */
}

@keyframes load-progress {
    0% {
        stroke-dashoffset: 282.7;
    }
    100% {
        stroke-dashoffset: 0;
    }
}

.flag-center {
    width: 60%; /* Adjust size of the flag */
    height: 60%;
    object-fit: contain;
    position: absolute;
    border-radius: 50%; /* Make it circular */
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.5); /* Optional: add a subtle shadow */
}

.radar-text-overlay {
    position: absolute;
    display: flex;
    flex-direction: column;
    align-items: center;
    color: white;
    font-family: 'Bungee', cursive; /* Use Bungee for the main title */
    text-align: center;
    text-shadow: 0 0 10px rgba(0, 255, 255, 0.8), 0 0 20px rgba(0, 255, 255, 0.6); /* Neon text shadow */
}

.radar-title {
    font-size: 2.2em; /* Adjust size */
    line-height: 1;
}

.port-text {
    font-family: 'GE Flow', sans-serif; /* Use GE Flow for the subtitle */
    font-size: 0.9em; /* Adjust size */
    margin-top: 5px;
}

/* Responsive adjustments for the loader */
@media (max-width: 768px) {
    .loader-circle-container {
        width: 350px;
        height: 350px;
    }
    .radar-title {
        font-size: 1.8em;
    }
    .port-text {
        font-size: 0.7em;
    }
    .loader-progress {
        stroke-width: 6;
    }
}

@media (max-width: 480px) {
    .loader-circle-container {
        width: 280px;
        height: 280px;
    }
    .radar-title {
        font-size: 1.5em;
    }
    .port-text {
        font-size: 0.6em;
    }
    .loader-progress {
        stroke-width: 5;
    }
}

.btn-logout {
    background: transparent;
    border: none;
    cursor: pointer;
    padding: 5px;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: opacity 0.2s ease;
    width: 25px;
    height: 25px;
}

.btn-logout:hover {
    opacity: 0.7;
}

.btn-logout svg {
    width: 100%;
    height: 100%;
}

.location-container {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    text-align: center;
}

.location-label {
    color: white;
    font-size: 0.8em;
    margin-top: 12px;
    text-align: center;
}

</style>
