<template>
    <div v-if="showPrompt" class="mobile-install-prompt">
        <div class="prompt-content">
            <div class="prompt-icon">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M12 2v20M2 12h20" />
                </svg>
            </div>
            <div class="prompt-text">
                <h3>Install App</h3>
                <p>Add this app to your home screen for quick access and better experience!</p>
            </div>
            <div class="prompt-actions">
                <button @click="handleInstall" class="btn-install">
                    Install
                </button>
                <button @click="dismissPrompt" class="btn-dismiss">
                    Not Now
                </button>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { ref, onMounted, onUnmounted } from 'vue';

const showPrompt = ref(false);
let deferredPrompt: any = null;
const dismissedKey = 'mobile-install-prompt-dismissed';

const isMobile = () => {
    return /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ||
           (window.matchMedia && window.matchMedia('(max-width: 768px)').matches);
};

const isStandalone = () => {
    return (window.navigator as any).standalone === true ||
           window.matchMedia('(display-mode: standalone)').matches ||
           document.referrer.includes('android-app://');
};

const wasDismissed = () => {
    return localStorage.getItem(dismissedKey) === 'true';
};

const handleBeforeInstallPrompt = (e: Event) => {
    // Prevent the default browser install prompt
    e.preventDefault();
    deferredPrompt = e;
    
    // Only show if on mobile, not already installed, and not dismissed
    if (isMobile() && !isStandalone() && !wasDismissed()) {
        showPrompt.value = true;
    }
};

const handleInstall = async () => {
    if (!deferredPrompt) {
        // Fallback: Show instructions for manual installation
        showInstallInstructions();
        dismissPrompt();
        return;
    }

    // Show the install prompt
    deferredPrompt.prompt();
    
    // Wait for the user to respond
    const { outcome } = await deferredPrompt.userChoice;
    
    if (outcome === 'accepted') {
        console.log('User accepted the install prompt');
        // Save that user wants to remember credentials
        localStorage.setItem('remember-install', 'true');
    }
    
    deferredPrompt = null;
    dismissPrompt();
};

const showInstallInstructions = () => {
    const isIOS = /iPad|iPhone|iPod/.test(navigator.userAgent);
    const isAndroid = /Android/.test(navigator.userAgent);
    
    let message = '';
    if (isIOS) {
        message = 'To install: Tap the Share button and select "Add to Home Screen"';
    } else if (isAndroid) {
        message = 'To install: Tap the menu (⋮) and select "Add to Home Screen" or "Install App"';
    } else {
        message = 'To install: Look for the install icon in your browser\'s address bar';
    }
    
    alert(message);
};

const dismissPrompt = () => {
    showPrompt.value = false;
    localStorage.setItem(dismissedKey, 'true');
    // Don't show again for 7 days
    setTimeout(() => {
        localStorage.removeItem(dismissedKey);
    }, 7 * 24 * 60 * 60 * 1000);
};

onMounted(() => {
    // Only show on mobile devices
    if (isMobile() && !isStandalone() && !wasDismissed()) {
        window.addEventListener('beforeinstallprompt', handleBeforeInstallPrompt);
        
        // Also check if app is installable (PWA criteria met)
        // Show prompt after a short delay if criteria are met
        setTimeout(() => {
            if (!deferredPrompt && isMobile() && !isStandalone()) {
                // Check if service worker is registered (PWA requirement)
                if ('serviceWorker' in navigator) {
                    navigator.serviceWorker.getRegistration().then(registration => {
                        if (registration) {
                            // PWA is installable, show custom prompt
                            showPrompt.value = true;
                        }
                    });
                }
            }
        }, 2000); // Show after 2 seconds
    }
});

onUnmounted(() => {
    window.removeEventListener('beforeinstallprompt', handleBeforeInstallPrompt);
});
</script>

<style scoped>
.mobile-install-prompt {
    position: fixed;
    bottom: 20px;
    left: 50%;
    transform: translateX(-50%);
    width: 90%;
    max-width: 400px;
    z-index: 9999;
    animation: slideUp 0.3s ease-out;
}

@keyframes slideUp {
    from {
        transform: translateX(-50%) translateY(100%);
        opacity: 0;
    }
    to {
        transform: translateX(-50%) translateY(0);
        opacity: 1;
    }
}

.prompt-content {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 16px;
    padding: 20px;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3);
    color: white;
    display: flex;
    flex-direction: column;
    gap: 15px;
}

.prompt-icon {
    display: flex;
    justify-content: center;
    align-items: center;
    width: 48px;
    height: 48px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 50%;
    margin: 0 auto;
    color: white;
}

.prompt-text {
    text-align: center;
}

.prompt-text h3 {
    margin: 0 0 8px 0;
    font-size: 18px;
    font-weight: 600;
}

.prompt-text p {
    margin: 0;
    font-size: 14px;
    opacity: 0.9;
    line-height: 1.4;
}

.prompt-actions {
    display: flex;
    gap: 10px;
    margin-top: 10px;
}

.btn-install,
.btn-dismiss {
    flex: 1;
    padding: 12px 20px;
    border: none;
    border-radius: 8px;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s;
}

.btn-install {
    background: white;
    color: #667eea;
}

.btn-install:hover {
    background: #f0f0f0;
    transform: translateY(-1px);
}

.btn-dismiss {
    background: rgba(255, 255, 255, 0.2);
    color: white;
    border: 1px solid rgba(255, 255, 255, 0.3);
}

.btn-dismiss:hover {
    background: rgba(255, 255, 255, 0.3);
}

@media (max-width: 480px) {
    .mobile-install-prompt {
        width: 95%;
        bottom: 10px;
    }
    
    .prompt-content {
        padding: 16px;
    }
}
</style>

