
function updateVhUnit() {
    let vh = window.innerHeight * 0.01;
    document.documentElement.style.setProperty('--vh', `${vh}px`);
}

updateVhUnit(); // Initial run
window.addEventListener('resize', updateVhUnit);
window.addEventListener('orientationchange', updateVhUnit);

function OnExit(url) {
    console.log("Callback OnExit Called with url:" + url);
    window.location.href = url;
}
function OnAuthSuccess(data) {
    console.log("Callback OnAuthSuccess Called with data:", data);
}
function OnMatchStart(data) {
    console.log("Callback OnMatchStart Called with data:", data);
}
function OpenLoginURL(url){


    const isPwa = window.matchMedia('(display-mode: standalone)').matches ||
                  window.navigator.standalone === true;

    if (isPwa) {
        url = url+"_pwa";
        console.log("Opening PWA: "+url);
        window.location.href = url; // remove _pwa
    } else {
        const popupurl = url+"_popup";
        console.log("Opening Popup: "+popupurl);
        const popup = window.open(popupurl, 'loginPopup', 'width=500,height=600,scrollbars=yes,resizable=yes');

        // fallback if popup blocked
        if (!popup || popup.closed || typeof popup.closed === 'undefined') {
            console.log("Unable to open Popup, fallback: "+url);
            window.location.href = url;
        }
    }
}




const container = document.querySelector("#unity-container");
const canvas = document.querySelector("#unity-canvas");
const loadingBar = document.querySelector("#unity-loading-bar");
const progressBarFull = document.querySelector("#unity-progress-bar-full");
const loadingText = document.querySelector("#loading-text");

// Device detection
if (/iPhone|iPad|iPod|Android/i.test(navigator.userAgent)) {
    container.classList.add("mobile");
} else {
    container.classList.add("desktop");
}

var buildUrl = "Build";
var config = {
    dataUrl: buildUrl + "/v1.0.4.data",
    frameworkUrl: buildUrl + "/v1.0.4.framework.js",
    codeUrl: buildUrl + "/v1.0.4.wasm",
    streamingAssetsUrl: "StreamingAssets",
    companyName: "DefaultCompany",
    productName: "Earnia",
    productVersion: "1.0",
    contextAttributes: {
        alpha: true
    },
    autoSyncPersistentDataPath: true
};

createUnityInstance(canvas, config, (progress) => {
    progressBarFull.style.width = (100 * progress) + "%";
    loadingText.innerText = "Loading... " + Math.round(progress * 100) + "%";
}).then((unityInstance) => {
    loadingBar.style.display = "none";
    window.unityInstance = unityInstance;
}).catch((message) => {
    alert(message);
});

function unityShowBanner(msg, type) {
    const warningBanner = document.querySelector("#unity-warning");
    function updateBannerVisibility() {
        warningBanner.style.display = warningBanner.children.length ? 'block' : 'none';
    }
    var div = document.createElement('div');
    div.innerHTML = msg;
    warningBanner.appendChild(div);
    if (type == 'error') {
        div.style = 'background: red; padding: 10px;';
    } else {
        if (type == 'warning') div.style = 'background: yellow; padding: 10px;';
        setTimeout(function () {
            warningBanner.removeChild(div);
            updateBannerVisibility();
        }, 5000);
    }
    updateBannerVisibility();
}



// console.log = function () { };
// console.warn = function () { };
// console.error = function () { };
