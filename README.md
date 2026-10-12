# GameCDN - Rent-Based Game Hosting

Welcome to the official **GameCDN** repository. We provide high-quality, rent-based games that you can easily integrate into your own website, platform, or application.

## 🎮 Available Games
- **Ludo**
- **Math**
- **Lucky Roll**
- **Earnia**

## 🚀 Integration Guide
To use these games, you must first manage your subscription and authorization at our official portal:
👉 [rent-a-game.topuvai.com](https://rent-a-game.topuvai.com)

### ⚠️ Important Migration Note
We have recently updated our game integration structure. All `.php` entry points have been replaced with `.html` files.
- **Old:** `[game-folder]/start.php?parameters...`
- **New:** `[game-folder]/start.html?parameters...`
Please update your integration links accordingly.

## 🛠 How to Use
Simply point your iframe or redirect to the `start.html` file within the respective game folder, passing the required parameters as defined in your subscription.

Example:
`https://play.topuvai.com/ludo/start.html?subscription_id=YOUR_ID&token=YOUR_TOKEN`

---
*GameCDN - Powering your platform with engaging games.*
