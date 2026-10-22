<?php
/**
 * Wolfie game markup. Static — no user data is output here.
 *
 * Available variables: $show_intro (bool), $show_header (bool).
 * JavaScript hooks use data-w attributes; styling uses classes, all scoped
 * under #mbr-wolfie so neither the theme nor the game leaks into the other.
 *
 * @package MBR_Wolfie_Slots
 */

defined( 'ABSPATH' ) || exit;
?>
<div id="mbr-wolfie" class="mbr-wolfie" tabindex="-1" aria-label="Wolfie — Moonlight Slots">
	<div class="sky" aria-hidden="true"><div class="moon"></div><div class="mountain m1"></div><div class="mountain m2"></div><div class="forest"></div></div>

	<div class="w-header<?php echo $show_header ? '' : ' is-compact'; ?>">
		<?php if ( $show_header ) : ?>
			<span class="brand"><span class="brand-mark">W</span> WOLFIE <span class="brand-sub">MOONLIGHT SLOTS</span></span>
		<?php endif; ?>
		<div class="header-actions">
			<?php if ( $show_header ) : ?><span class="play-label">● PLAY TOKENS ONLY</span><?php endif; ?>
			<button type="button" data-w="sound" class="quiet" aria-pressed="true">♪ Sound on</button>
			<button type="button" data-w="help" class="quiet">How to play ↗</button>
		</div>
	</div>

	<div class="w-main">
		<?php if ( $show_intro ) : ?>
			<div class="intro"><div class="eyebrow">THE WILD HAS A REWARD</div><h1>WOLFIE<span>✦</span></h1><p>Follow the moon. Find your fortune.</p></div>
		<?php endif; ?>

		<div class="game-layout">
			<div class="left-panel">
				<div class="section-label">THE NIGHT'S BIGGEST PRIZE</div>
				<h2>Big Prize<br><em>Run.</em></h2>
				<div class="wolf-portrait" data-w="portrait"></div>
				<p>Find <strong>3 wolves anywhere</strong><br>to awaken the bonus.</p>
				<div class="feature"><span>01</span><div><strong>5–9 free spins</strong><small>Let the wild take over.</small></div></div>
				<div class="feature"><span>02</span><div><strong>Every spin wins</strong><small>One big payout at the end.</small></div></div>
				<div class="scatter-meter" data-w="scatterMeter"><i></i><i></i><i></i></div>
				<small class="w-wolfcount" data-w="wolfCount">The pack is waiting.</small>
			</div>

			<div class="machine" role="region" aria-label="Wolfie slot machine">
				<div class="machine-top"><span><i class="live-dot"></i> <span class="w-mode" data-w="mode">DANNY'S REELS</span></span><span>4 REELS <b>·</b> 4 PAYLINES</span></div>
				<div class="reel-frame">
					<div class="line-labels" aria-hidden="true"><span>1</span><span>2</span><span>3</span><span>4</span></div>
					<div data-w="reels" class="reels" aria-label="Four reels with four symbols each"></div>
					<div data-w="winFlash" class="win-flash" aria-hidden="true"></div>
				</div>
				<div class="message-strip" role="status" aria-live="polite"><span class="w-message" data-w="message">The moon is high. Take your first spin.</span><span class="w-message-detail" data-w="messageDetail">3 wolves anywhere unlock the Big Prize Run</span></div>
				<div class="dashboard">
					<div class="balance"><span class="w-label">YOUR TOKENS</span><strong data-w="balance">100</strong><small>✦ PLAY BALANCE</small></div>
					<div class="wager"><span class="w-label">WAGER PER SPIN</span><div class="stepper"><button type="button" data-w="minus" aria-label="Decrease wager">−</button><strong data-w="bet">1</strong><button type="button" data-w="plus" aria-label="Increase wager">+</button></div><small>1–5 TOKENS</small></div>
					<button type="button" data-w="spin" class="spin"><span data-w="spinLabel">SPIN</span><span data-w="spinSub">LET THE WILD IN ↗</span></button>
				</div>
				<div class="machine-bottom"><span data-w="lastWin">LAST WIN <b>—</b></span><span>SPACE TO SPIN <kbd>␣</kbd></span></div>
			</div>

			<div class="right-panel">
				<div class="section-label">KNOW YOUR TREASURES</div>
				<h2>The paytable</h2>
				<p>Match across any horizontal row.<br>Prizes multiply your wager.</p>
				<div class="pay-head"><span>SYMBOL</span><span>3</span><span>4</span></div>
				<div data-w="paytable"></div>
				<div class="scatter-rule"><span data-w="smallWolf"></span><p><strong>WOLF SCATTER</strong><small>3+ anywhere = Big Prize Run</small></p></div>
				<div class="fine-rule">Three consecutive matches, starting from either edge. The best match pays once per row. All four rows are included.</div>
			</div>
		</div>

		<div class="w-footer"><span>✦ A LITTLE WILDER AFTER DARK.</span><span>Just for fun. No purchases. No cash prizes.</span><button type="button" class="w-reset" data-w="reset">Start fresh</button></div>
	</div>

	<dialog data-w="helpDialog" aria-labelledby="mbr-wolfie-help-title">
		<button type="button" class="close" data-w="closeHelp" aria-label="Close instructions">×</button>
		<div class="eyebrow">WELCOME TO THE PACK</div>
		<h2 id="mbr-wolfie-help-title">A night with Wolfie</h2>
		<p>Start with 100 play tokens. Choose a wager of 1–5 tokens, then press Spin or Space. Your wager covers all four horizontal rows.</p>
		<p>Three identical treasure symbols in adjacent positions 1–3 or 2–4 pay the 3-symbol prize. Four identical symbols pay the 4-symbol prize instead. Winning rows add together.</p>
		<p>Three or more wolves anywhere in the 4×4 window trigger 5–9 free spins. Every bonus spin wins, using the wager that triggered the bonus. Winnings accumulate and are credited together after the final free spin. Wolves do not retrigger the bonus.</p>
		<div class="help-payouts"><strong>Payouts (3 / 4 matches)</strong><p>Moon 5× / 20× · Ruby 3× / 12× · Sapphire 2× / 8× · Emerald 2× / 6× · Amber 1× / 4×. Multiply by your wager.</p></div>
		<p>Each base-game cell is drawn independently: amber 25%, emerald 23%, sapphire 22%, ruby 17%, moon 10.5%, wolf 2.5%. During the bonus, a non-winning board is given a guaranteed matching row. This is a casual simulator, with no cash value or advertised return-to-player.</p>
		<p>Progress stays in this browser. Sound is synthesized locally. “Start fresh” resets your balance and bonus.</p>
		<button type="button" data-w="gotIt" class="primary">LET'S PLAY</button>
	</dialog>

	<dialog data-w="bonusDialog" class="w-bonus-dialog" aria-labelledby="mbr-wolfie-bonus-title">
		<div class="eyebrow" data-w="bonusEyebrow">THE PACK HAS AWAKENED</div>
		<div class="bonus-wolf" data-w="bonusWolf"></div>
		<h2 id="mbr-wolfie-bonus-title" data-w="bonusTitle">Big Prize Run</h2>
		<p data-w="bonusText"></p>
		<button type="button" data-w="bonusContinue" class="primary">ENTER THE WILD</button>
	</dialog>
</div>
