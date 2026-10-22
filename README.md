# MBR Wolfie Slots

**Wolfie — Moonlight Slots.** A moonlit four-reel slot simulator for WordPress, with play tokens,
original vector artwork, synthesized sound and the Big Prize Run bonus. Drop it on any page with
one shortcode.

Free, GPL-licensed, self-hosted. No telemetry, no CDN dependencies, no accounts, no purchases and
no cash prizes. Nothing is stored on your server.

**Current version:** 1.0.1
**Requires:** WordPress 6.3+ · PHP 7.4+
**Tested to:** WordPress 7.1
**Licence:** GPLv2 or later

---

## Quick start

1. Download `mbr-wolfie-slots-1.0.1.zip`.
2. In WordPress, go to **Plugins → Add New Plugin → Upload Plugin**, choose the ZIP and click **Install Now**.
3. Click **Activate**.
4. Add the shortcode to any page or post:

```
[mbr_wolfie]
```

That's it. There is no settings screen to configure.

## Shortcode

| Shortcode | What it does |
|---|---|
| `[mbr_wolfie]` | The full game: brand bar, WOLFIE title, bonus panel, machine and paytable |
| `[mbr_wolfie intro="no"]` | Hides the large WOLFIE title block. Useful when your page already has a heading |
| `[mbr_wolfie header="no"]` | Hides the brand bar. **Sound** and **How to play** stay, in a slim bar |
| `[mbr_wolfie intro="no" header="no"]` | The most compact version |
| `[wolfie]` | Short alias. Only registered if no other plugin has claimed the tag |

Attributes accept `yes`/`no` (also `true`/`false`, `on`/`off`, `1`/`0`).

**Where it works:** the block editor (Shortcode block), the Classic editor, Elementor (Shortcode
widget), widget areas, and theme templates via `do_shortcode()`. One game per page: a second copy
shows a short notice, because both would share the same balance.

## How the game plays

- Players start with **100 play tokens** and wager **1–5 tokens** per spin.
- Each wager covers **all four horizontal rows**.
- **Three** matching symbols in a row, starting from either edge, pay the 3-symbol prize. **Four**
  matching pay the larger 4-symbol prize instead. All winning rows are added together.
- **Three or more wolves anywhere** trigger the **Big Prize Run**: 5–9 free spins at the triggering
  wager. Every bonus spin wins, the pot builds up, and the whole lot is paid at the end. Wolves do
  not retrigger the bonus.

| Symbol | 3 match | 4 match | Cell probability |
|---|---:|---:|---:|
| Moon | 5× | 20× | 10.5% |
| Ruby | 3× | 12× | 17% |
| Sapphire | 2× | 8× | 22% |
| Emerald | 2× | 6× | 23% |
| Amber | 1× | 4× | 25% |
| Wolf | Bonus scatter | Bonus scatter | 2.5% |

Prizes multiply the wager. Each base-game cell is drawn independently.

**Controls:** click **Spin**, or click the machine and press **Space**. Space only spins while the
game has focus, so it never stops visitors scrolling the page.

**Saving:** balance, wager, sound preference and any unfinished bonus are saved in the visitor's
own browser (`localStorage` key `mbr_wolfie.v1`). Each result is saved *before* its animation,
so closing the tab mid-spin never loses a win. **Start fresh** resets to 100 tokens.

**Sound** is synthesized live with the Web Audio API (howls, reel clicks, cash-register
payouts), with no audio files to download. It starts after the first interaction, as browsers
require. Visitors who prefer reduced motion get the results without the reel animation.

## Automatic updates

The plugin updates itself from a self-hosted feed using the bundled
[Plugin Update Checker](https://github.com/YahnisElsts/plugin-update-checker) 5.7. New versions
show up in **Dashboard → Updates** and on the **Plugins** screen, just like plugins from
WordPress.org.

The feed URL is held in a constant, so you can override it from `wp-config.php` and an update
never overwrites your setting:

```php
// Use a different update feed.
define( 'MBR_WOLFIE_UPDATE_URL', 'https://example.com/my-feed/mbr-wolfie-slots.json' );

// Or switch update checks off entirely.
define( 'MBR_WOLFIE_UPDATE_URL', '' );
```

Default feed: `https://raw.githubusercontent.com/HarbourBob/mbr-updates/main/mbr-wolfie-slots.json`

## For developers

### Asset loading

CSS and JavaScript load **only on pages that contain the game**. The plugin checks the post
content and Elementor's `_elementor_data` early, so the stylesheet goes in the `<head>`. If the
shortcode turns up somewhere it couldn't predict (a widget, a template call), the shortcode
callback enqueues the assets as a fallback.

Force the assets to load (or not) on any request:

```php
add_filter( 'mbr_wolfie_load_assets', '__return_true' );
```

### Theme isolation

- Every style is scoped under `#mbr-wolfie`. The ID's specificity beats class-based theme and
  Elementor Kit rules, and nothing leaks out into the page.
- The layout uses **CSS container queries**, so it adapts to the width of the column it sits in,
  not the browser window: three columns when wide, two in a typical content column, one on phones.
- JavaScript lookups are scoped to the game container via `data-w` attributes, so generic IDs in
  your theme can't collide with the game.
- Dialogs use the native `<dialog>` element and render in the browser's top layer, above sticky
  headers and page builders.

### File structure

```
mbr-wolfie-slots/
├── mbr-wolfie-slots.php        Bootstrap, update checker, shortcode, asset loading
├── templates/game.php          Static game markup (no user data output)
├── assets/css/wolfie.css       Scoped styles
├── assets/js/engine.js         Pure game logic: symbols, odds, evaluation, board generation
├── assets/js/app.js            UI, animation, sound, saving
├── assets/icon-128x128.png
├── includes/vendor/plugin-update-checker/   PUC 5.7 (MIT)
├── readme.txt
├── README.md
└── MBR-Wolfie-Slots-User-Guide-v1.0.1.pdf
```

`engine.js` exports `WolfieEngine` (`symbols`, `pick`, `evaluate`, `generate`) and also works under
Node via `module.exports`, so the maths can be unit-tested without a browser.

## Privacy

Wolfie makes no network requests, sets no cookies and collects nothing. The only stored data is
the player's own game state in their browser's `localStorage`. It is never sent anywhere and
can be cleared with **Start fresh** or by clearing site data. No consent banner entry is needed.

## Responsible play

Wolfie is a casual simulator. Tokens have no cash value, cannot be bought and cannot be
withdrawn, and the game advertises no return-to-player figure. It says so on screen: *"Just for
fun. No purchases. No cash prizes."*

## Changelog

### 1.0.1
- New: automatic updates via Plugin Update Checker 5.7 (self-hosted feed). Override or disable
  with the `MBR_WOLFIE_UPDATE_URL` constant.
- New: README.md and a PDF user guide.

### 1.0.0
- Initial release. Ported from the Wolfie Chrome extension (v1.0.3).

## Credits

Built by [Robert Palmer](https://madebyrobert.co.uk) · [Little Web Shack](https://littlewebshack.com)

Bundles [Plugin Update Checker](https://github.com/YahnisElsts/plugin-update-checker) by Janis Elsts (MIT).
