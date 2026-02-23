(function () {
  'use strict';

  // ── Helpers ────────────────────────────────────────────────────────────────

  function roundedRect(ctx, x, y, w, h, r) {
    ctx.beginPath();
    ctx.moveTo(x + r, y);
    ctx.lineTo(x + w - r, y);
    ctx.quadraticCurveTo(x + w, y, x + w, y + r);
    ctx.lineTo(x + w, y + h - r);
    ctx.quadraticCurveTo(x + w, y + h, x + w - r, y + h);
    ctx.lineTo(x + r, y + h);
    ctx.quadraticCurveTo(x, y + h, x, y + h - r);
    ctx.lineTo(x, y + r);
    ctx.quadraticCurveTo(x, y, x + r, y);
    ctx.closePath();
  }

  // Count how many lines the text will wrap to (without drawing)
  function countLines(ctx, text, maxWidth) {
    var words = text.split(' ');
    var line  = '';
    var count = 0;
    for (var i = 0; i < words.length; i++) {
      var test = line + words[i] + ' ';
      if (ctx.measureText(test).width > maxWidth && i > 0) {
        count++;
        line = words[i] + ' ';
      } else {
        line = test;
      }
    }
    if (line.trim()) count++;
    return count;
  }

  // Truncate text to maxLines, appending '…' if cut
  function truncateToLines(ctx, text, maxWidth, maxLines) {
    var words = text.split(' ');
    var line  = '';
    var lines = [];
    for (var i = 0; i < words.length; i++) {
      var test = line + words[i] + ' ';
      if (ctx.measureText(test).width > maxWidth && i > 0) {
        lines.push(line.trim());
        if (lines.length >= maxLines) break;
        line = words[i] + ' ';
      } else {
        line = test;
      }
    }
    // Remaining text
    if (lines.length < maxLines && line.trim()) {
      lines.push(line.trim());
    } else if (lines.length === maxLines) {
      // Append ellipsis to last line
      var last = lines[maxLines - 1];
      while (ctx.measureText(last + '…').width > maxWidth && last.length > 0) {
        last = last.slice(0, last.lastIndexOf(' '));
      }
      lines[maxLines - 1] = last + '…';
    }
    return lines.join(' ');
  }

  // Draw wrapped text, returns total height consumed
  function drawWrapped(ctx, text, x, y, maxWidth, lineHeight) {
    var words = text.split(' ');
    var line  = '';
    var lines = [];
    for (var i = 0; i < words.length; i++) {
      var test = line + words[i] + ' ';
      if (ctx.measureText(test).width > maxWidth && i > 0) {
        lines.push(line.trim());
        line = words[i] + ' ';
      } else {
        line = test;
      }
    }
    lines.push(line.trim());
    lines.forEach(function (l, idx) {
      ctx.fillText(l, x, y + idx * lineHeight);
    });
    return lines.length * lineHeight;
  }

  function loadImage(src) {
    return new Promise(function (resolve, reject) {
      var img = new Image();
      img.crossOrigin = 'anonymous';
      img.onload  = function () { resolve(img); };
      img.onerror = reject;
      img.src = src;
    });
  }

  function downloadImage(dataUrl) {
    var a = document.createElement('a');
    a.href     = dataUrl;
    a.download = 'instagram-story.png';
    a.click();
  }

  // ── Canvas generator ───────────────────────────────────────────────────────

  async function generateCanvas(btn) {
    var title       = btn.dataset.title       || '';
    var siteUrl     = btn.dataset.url         || '';
    var readingTime = btn.dataset.readingTime || '1 min';
    var category    = btn.dataset.category    || '';
    var author      = btn.dataset.author      || '';
    var avatarUrl   = btn.dataset.avatar      || '';
    var imageUrl    = btn.dataset.image       || '';
    var excerpt     = btn.dataset.excerpt     || '';

    var domain = siteUrl.replace(/^https?:\/\//, '');

    var W = 1080;
    var H = 1920;

    var canvas = document.createElement('canvas');
    canvas.width  = W;
    canvas.height = H;
    var ctx = canvas.getContext('2d');

    // ── 1. Blurred background ─────────────────────────────────────────────────
    // Scale-down → scale-up blur: works on all browsers including iOS Safari
    // (ctx.filter is not supported on Safari < 18)
    if (imageUrl) {
      try {
        var bgImg = await loadImage(imageUrl);
        // Multi-pass downscale: each halving pass interpolates smoothly,
        // accumulating into a gaussian-like blur without pixelation.
        var tmp = document.createElement('canvas');
        tmp.width = W; tmp.height = H;
        var tmpCtx = tmp.getContext('2d');
        tmpCtx.drawImage(bgImg, 0, 0, W, H);
        for (var p = 0; p < 6; p++) {
          var next = document.createElement('canvas');
          next.width  = Math.round(tmp.width  * 0.5);
          next.height = Math.round(tmp.height * 0.5);
          var nCtx = next.getContext('2d');
          nCtx.imageSmoothingEnabled = true;
          nCtx.imageSmoothingQuality = 'high';
          nCtx.drawImage(tmp, 0, 0, next.width, next.height);
          tmp = next;
        }
        ctx.imageSmoothingEnabled = true;
        ctx.imageSmoothingQuality = 'high';
        ctx.drawImage(tmp, 0, 0, W, H);
      } catch (_) {
        ctx.fillStyle = '#1B1B1B';
        ctx.fillRect(0, 0, W, H);
      }
    } else {
      ctx.fillStyle = '#1B1B1B';
      ctx.fillRect(0, 0, W, H);
    }

    // Dark overlay for readability
    ctx.fillStyle = 'rgba(0,0,0,0.40)';
    ctx.fillRect(0, 0, W, H);

    // ── 2. Measure title to calculate card height ─────────────────────────────
    var SIDE_W     = 84;               // right strip width (vertical rule + URL)
    var cX         = 60;
    var cW         = 960;
    var TITLE_FONT = '400 72px Anton, sans-serif';
    var TITLE_LH   = 88;               // line height
    var TITLE_MAX_W = cW - SIDE_W - 96; // left padding 48 + right gap 48 = 96

    ctx.font = TITLE_FONT;
    var titleLineCount = countLines(ctx, title, TITLE_MAX_W);
    var titleH         = titleLineCount * TITLE_LH;

    // Card sections (fixed overhead):
    //   TOP_SEC  = top-pad(56) + reading-time-text(68) + gap(32) + rule-height(0) = 156 → use 160
    //   CONT_PAD = gap above/below title = 72 each
    //   FOOT_SEC = rule-gap(24) + footer(96) + bottom-pad(48) = 168 → use 172
    var TOP_SEC  = 160;
    var CONT_PAD = 72;
    var FOOT_SEC = 172;

    // Excerpt constants
    var EXCERPT_FONT      = '400 40px Roboto, sans-serif';
    var EXCERPT_LH        = 58;
    var EXCERPT_GAP       = 40;
    var EXCERPT_MAX_LINES = 3;

    ctx.font = EXCERPT_FONT;
    var excerptLineCount = excerpt
      ? Math.min(countLines(ctx, excerpt, TITLE_MAX_W), EXCERPT_MAX_LINES)
      : 0;
    var excerptH      = excerptLineCount * EXCERPT_LH;
    var excerptOffset = excerptLineCount > 0 ? EXCERPT_GAP + excerptH : 0;

    var cH = TOP_SEC + CONT_PAD + titleH + excerptOffset + CONT_PAD + FOOT_SEC;
    var cR = 32;

    // Center card vertically, with a minimum 100px margin top/bottom
    var cY = Math.round((H - cH) / 2);
    cY = Math.max(100, Math.min(cY, H - cH - 100));

    // ── 3. Draw white card ────────────────────────────────────────────────────
    ctx.save();
    roundedRect(ctx, cX, cY, cW, cH, cR);
    ctx.fillStyle = '#ffffff';
    ctx.fill();
    ctx.restore();

    // ── 4. Key Y coordinates (all relative to cY) ─────────────────────────────
    var rule1Y   = cY + TOP_SEC;
    var contentY = rule1Y + CONT_PAD;
    var rule2Y   = contentY + titleH + excerptOffset + CONT_PAD;

    // ── 5. Reading-time strip (above rule1) ───────────────────────────────────
    ctx.save();
    ctx.font = '400 38px Roboto, sans-serif';
    ctx.fillStyle = '#888888';
    ctx.textBaseline = 'middle';
    ctx.fillText(readingTime + ' read', cX + 48, cY + TOP_SEC / 2);
    ctx.restore();

    // ── 6. Horizontal rule #1 ─────────────────────────────────────────────────
    ctx.save();
    ctx.strokeStyle = '#333333';
    ctx.lineWidth = 2;
    ctx.beginPath();
    ctx.moveTo(cX + 24,      rule1Y);
    ctx.lineTo(cX + cW - 24, rule1Y);
    ctx.stroke();
    ctx.restore();

    // ── 7. Right strip: vertical divider + rotated URL ────────────────────────
    var sideX = cX + cW - SIDE_W;

    ctx.save();
    ctx.strokeStyle = '#333333';
    ctx.lineWidth = 2;
    ctx.beginPath();
    ctx.moveTo(sideX, rule1Y + 20);
    ctx.lineTo(sideX, rule2Y - 20);
    ctx.stroke();
    ctx.restore();

    var urlCX = sideX + SIDE_W / 2;
    var urlCY = (rule1Y + rule2Y) / 2;
    ctx.save();
    ctx.translate(urlCX, urlCY);
    ctx.rotate(-Math.PI / 2);
    ctx.font = '400 32px Roboto, sans-serif';
    ctx.fillStyle = '#999999';
    ctx.textAlign = 'center';
    ctx.textBaseline = 'middle';
    ctx.fillText(domain, 0, 0);
    ctx.restore();

    // ── 8. Post title ─────────────────────────────────────────────────────────
    ctx.save();
    ctx.font = TITLE_FONT;
    ctx.fillStyle = '#1B1B1B';
    ctx.textBaseline = 'top';
    drawWrapped(ctx, title, cX + 48, contentY, TITLE_MAX_W, TITLE_LH);
    ctx.restore();

    // ── 8b. Excerpt ───────────────────────────────────────────────────────────
    if (excerpt && excerptLineCount > 0) {
      var truncated = truncateToLines(ctx, excerpt, TITLE_MAX_W, EXCERPT_MAX_LINES);
      ctx.save();
      ctx.font = EXCERPT_FONT;
      ctx.fillStyle = '#555555';
      ctx.textBaseline = 'top';
      drawWrapped(ctx, truncated, cX + 48, contentY + titleH + EXCERPT_GAP, TITLE_MAX_W, EXCERPT_LH);
      ctx.restore();
    }

    // ── 9. Horizontal rule #2 ─────────────────────────────────────────────────
    ctx.save();
    ctx.strokeStyle = '#333333';
    ctx.lineWidth = 2;
    ctx.beginPath();
    ctx.moveTo(cX + 24,      rule2Y);
    ctx.lineTo(cX + cW - 24, rule2Y);
    ctx.stroke();
    ctx.restore();

    // ── 10. Footer ────────────────────────────────────────────────────────────
    var footerMidY = rule2Y + (cY + cH - rule2Y) / 2;
    var avSize = 56;
    var avX    = cX + 48;
    var avY    = footerMidY - avSize / 2;

    // Avatar circle
    if (avatarUrl) {
      try {
        var avImg = await loadImage(avatarUrl);
        ctx.save();
        ctx.beginPath();
        ctx.arc(avX + avSize / 2, avY + avSize / 2, avSize / 2, 0, Math.PI * 2);
        ctx.closePath();
        ctx.clip();
        ctx.drawImage(avImg, avX, avY, avSize, avSize);
        ctx.restore();
      } catch (_) {
        ctx.save();
        ctx.beginPath();
        ctx.arc(avX + avSize / 2, avY + avSize / 2, avSize / 2, 0, Math.PI * 2);
        ctx.fillStyle = '#e0e0e0';
        ctx.fill();
        ctx.restore();
      }
    }

    // Author name
    ctx.save();
    ctx.font = '500 36px Roboto, sans-serif';
    ctx.fillStyle = '#1B1B1B';
    ctx.textBaseline = 'middle';
    ctx.fillText(author, avX + avSize + 20, footerMidY);
    ctx.restore();

    // Category pill (right-aligned in footer)
    if (category) {
      var PILL_FONT   = '400 32px Roboto, sans-serif';
      var PILL_PAD_X  = 28;
      var PILL_PAD_Y  = 14;

      ctx.save();
      ctx.font = PILL_FONT;
      var catTextW = ctx.measureText(category).width;
      var pillW    = catTextW + PILL_PAD_X * 2;
      var pillH    = 32 + PILL_PAD_Y * 2;
      var pillX    = cX + cW - 48 - pillW;   // right-aligned
      var pillY    = footerMidY - pillH / 2;
      var PILL_RADIUS = pillH / 2;            // clamp to capsule shape

      roundedRect(ctx, pillX, pillY, pillW, pillH, PILL_RADIUS);
      ctx.fillStyle = '#333333';
      ctx.fill();

      ctx.fillStyle = '#ffffff';
      ctx.textBaseline = 'middle';
      ctx.fillText(category, pillX + PILL_PAD_X, pillY + pillH / 2);
      ctx.restore();
    }

    return canvas;
  }

  // ── Share handler ──────────────────────────────────────────────────────────

  async function handleShare(btn) {
    btn.classList.add('loading');

    try {
      var canvas = await generateCanvas(btn);

      canvas.toBlob(async function (blob) {
        try {
          var file = new File([blob], 'instagram-story.png', { type: 'image/png' });

          if (navigator.canShare && navigator.canShare({ files: [file] })) {
            await navigator.share({ files: [file] });
          } else {
            downloadImage(canvas.toDataURL('image/png'));
          }
        } catch (e) {
          if (e.name !== 'AbortError') {
            downloadImage(canvas.toDataURL('image/png'));
          }
        } finally {
          btn.classList.remove('loading');
        }
      }, 'image/png');

    } catch (e) {
      console.error('Instagram story generation failed:', e);
      btn.classList.remove('loading');
    }
  }

  // ── Init ───────────────────────────────────────────────────────────────────

  document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.share-instagram-btn').forEach(function (btn) {
      btn.addEventListener('click', function () {
        handleShare(btn);
      });
    });
  });
}());
