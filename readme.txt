=== MBR Wolfie Slots ===
Contributors: harbourbob
Tags: game, slots, shortcode, fun, simulator
Requires at least: 6.3
Tested up to: 7.1
Requires PHP: 7.4
Stable tag: 1.0.1
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Wolfie — Moonlight Slots. A moonlit four-reel slot simulator with play tokens, synthesized sound and the Big Prize Run, placed with a shortcode.

== Description ==

Wolfie is a casual, just-for-fun slot simulator: four reels, a 4×4 window, original vector artwork, synthesized wolf howls, reel clicks and cash-register payout sounds.

Everything runs in the visitor's browser. There are no accounts, no network requests, no purchases, no cash prizes, no telemetry and no CDN dependencies. Nothing is stored on your server.

= Shortcode =

`[mbr_wolfie]`

`[wolfie]` also works, unless another plugin has already claimed that tag.

Optional attributes:

* `intro="no"`: hide the large WOLFIE title block (useful when your page already has a heading).
* `header="no"`: hide the brand bar. The Sound and How to play buttons stay, in a slim bar.

Example: `[mbr_wolfie intro="no"]`

Works in the block editor (Shortcode block), the Classic editor, Elementor (Shortcode widget) and widget areas. One game per page.

= How to play =

Players start with 100 tokens and wager 1–5 tokens per spin, covering all four horizontal paylines. Three matching consecutive symbols starting from either edge win; four matching symbols pay the larger prize instead. All winning rows are added together.

| Symbol   | 3 match | 4 match | Cell probability |
| Moon     | 5×      | 20×     | 10.5% |
| Ruby     | 3×      | 12×     | 17%   |
| Sapphire | 2×      | 8×      | 22%   |
| Emerald  | 2×      | 6×      | 23%   |
| Amber    | 1×      | 4×      | 25%   |
| Wolf     | Bonus scatter | | 2.5% |

Three or more wolves anywhere trigger the Big Prize Run: 5–9 free spins at the triggering wager, where every spin wins. Bonus wins accumulate and are credited together at the end. Wolves do not retrigger.

Click the machine, then press Space to spin. Space only spins while the game has focus, so it never interferes with page scrolling.

Balance, wager, sound preference and any unfinished bonus are saved in the visitor's browser (localStorage). "Start fresh" resets to 100 tokens.

= Updates =

MBR Wolfie Slots updates itself like the rest of the MBR suite. New versions appear in Dashboard → Updates and on the Plugins screen, and you install them with one click. To point at a different update feed, or switch update checks off, define `MBR_WOLFIE_UPDATE_URL` in wp-config.php (an empty string disables checks).

= Developer notes =

* Assets load only on pages that contain the shortcode (post content or Elementor data). Anywhere else, the shortcode callback enqueues them as a fallback.
* Force loading with the `mbr_wolfie_load_assets` filter: `add_filter( 'mbr_wolfie_load_assets', '__return_true' );`
* All styles are scoped under `#mbr-wolfie`. Layout uses CSS container queries, so the game adapts to the width of the column it sits in.

== Upgrade Notice ==

= 1.0.1 =
Adds one-click automatic updates. No changes to the game or saved balances.

== Changelog ==

= 1.0.1 =
* New: automatic updates via Plugin Update Checker 5.7 (self-hosted feed). Override or disable with the MBR_WOLFIE_UPDATE_URL constant.
* New: README.md and a PDF user guide.

= 1.0.0 =
* Initial release. Ported from the Wolfie Chrome extension (v1.0.3).
