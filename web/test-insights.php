<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insights Test Suite</title>
    <style>
        * { box-sizing: border-box; }
        body { font-family: system-ui, sans-serif; max-width: 900px; margin: 0 auto; padding: 20px; background: #f5f5f5; }
        h1 { margin-bottom: 8px; }
        .subtitle { color: #666; margin-bottom: 24px; }
        .card { background: white; border-radius: 8px; padding: 20px; margin-bottom: 16px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); }
        .card h2 { margin: 0 0 16px 0; font-size: 16px; display: flex; align-items: center; gap: 8px; }
        .card h2 span { font-size: 20px; }
        .grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 16px; }
        button { padding: 10px 18px; margin: 4px; border: none; border-radius: 6px; cursor: pointer; font-size: 13px; font-weight: 500; transition: opacity 0.2s; }
        button:hover { opacity: 0.85; }
        .btn-blue { background: #3b82f6; color: white; }
        .btn-green { background: #22c55e; color: white; }
        .btn-purple { background: #8b5cf6; color: white; }
        .btn-orange { background: #f59e0b; color: white; }
        .btn-pink { background: #ec4899; color: white; }
        .btn-gray { background: #6b7280; color: white; }
        .btn-red { background: #ef4444; color: white; }
        .btn-sm { padding: 6px 12px; font-size: 12px; }
        a.btn { text-decoration: none; display: inline-block; }
        code { background: #e5e7eb; padding: 2px 6px; border-radius: 4px; font-size: 12px; }
        .info { font-size: 13px; color: #666; margin-bottom: 12px; }
        .tag { display: inline-block; padding: 2px 8px; border-radius: 4px; font-size: 11px; font-weight: 600; }
        .tag-pro { background: #fef3c7; color: #92400e; }
        .tag-lite { background: #dbeafe; color: #1e40af; }
        #log { background: #1a1a2e; color: #0f0; padding: 16px; border-radius: 6px; font-family: 'Monaco', 'Consolas', monospace; font-size: 11px; height: 300px; overflow-y: auto; }
        #log .time { color: #666; }
        #log .out { color: #4fc3f7; }
        #log .in { color: #0f0; }
        #log .err { color: #ff6b6b; }
        #log .warn { color: #ffd93d; }
        .status-bar { display: flex; gap: 16px; flex-wrap: wrap; font-size: 13px; padding: 12px 16px; background: #f8fafc; border-radius: 6px; margin-bottom: 12px; }
        .status-bar div { display: flex; align-items: center; gap: 6px; }
        .dot { width: 8px; height: 8px; border-radius: 50%; }
        .dot-green { background: #22c55e; }
        .dot-red { background: #ef4444; }
        .dot-yellow { background: #f59e0b; }
        .links { display: flex; gap: 8px; flex-wrap: wrap; margin-top: 8px; }
        .test-links a { color: #3b82f6; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; font-size: 13px; }
        th, td { padding: 8px; text-align: left; border-bottom: 1px solid #e5e7eb; }
        th { font-weight: 600; color: #666; }
        .detected { background: #f0fdf4; }
    </style>
</head>
<body>
    <h1>🔬 Insights Test Suite</h1>

    <!-- Status Bar -->
    <div class="status-bar" id="status-bar">
        <div><span class="dot dot-yellow" id="dot-connection"></span> Checking...</div>
    </div>

    <!-- Detection Info -->
    <div class="card">
        <h2><span>📊</span> Detected Data</h2>
        <table id="detection-table">
            <tr><th style="width:140px">Parameter</th><th>Value</th><th>Status</th></tr>
            <tr><td>URL</td><td><code id="det-url">-</code></td><td>-</td></tr>
            <tr><td>Referrer</td><td><code id="det-ref">-</code></td><td id="det-ref-status">-</td></tr>
            <tr><td>Screen</td><td><code id="det-screen">-</code></td><td>-</td></tr>
            <tr><td>utm_source</td><td><code id="det-utm-s">-</code></td><td id="det-utm-s-status">-</td></tr>
            <tr><td>utm_medium</td><td><code id="det-utm-m">-</code></td><td id="det-utm-m-status">-</td></tr>
            <tr><td>utm_campaign</td><td><code id="det-utm-c">-</code></td><td id="det-utm-c-status">-</td></tr>
            <tr><td>utm_term</td><td><code id="det-utm-t">-</code></td><td id="det-utm-t-status">-</td></tr>
            <tr><td>utm_content</td><td><code id="det-utm-n">-</code></td><td id="det-utm-n-status">-</td></tr>
        </table>
    </div>

    <div class="grid">
        <!-- Pageview Tests -->
        <div class="card">
            <h2><span>👁️</span> Pageviews</h2>
            <p class="info">Basic tracking for page views</p>
            <button class="btn-blue" onclick="sendPageview()">Send Pageview</button>
            <button class="btn-green" onclick="sendEngagement()">Engagement</button>
            <button class="btn-orange" onclick="sendLeave()">Leave (with time)</button>
        </div>

        <!-- Event Tests -->
        <div class="card">
            <h2><span>🎯</span> Events <span class="tag tag-pro">PRO</span></h2>
            <p class="info">Custom event tracking</p>
            <button class="btn-purple" data-insights-event="button_click" data-insights-category="test">Data-Attr Click</button>
            <button class="btn-pink" onclick="trackEvent('manual_test', 'test')">JS API</button>
            <button class="btn-gray" onclick="trackEvent('no_category')">Without Category</button>
        </div>

        <!-- Outbound Link Tests -->
        <div class="card">
            <h2><span>🔗</span> Outbound Links <span class="tag tag-pro">PRO</span></h2>
            <p class="info">Track clicks on external links</p>
            <div class="links" style="margin-bottom:12px">
                <a href="https://github.com" target="_blank" class="btn btn-sm btn-blue">GitHub →</a>
                <a href="https://www.google.com" target="_blank" class="btn btn-sm btn-green">Google →</a>
                <a href="https://twitter.com" target="_blank" class="btn btn-sm btn-purple">Twitter →</a>
            </div>
            <button class="btn-pink btn-sm" onclick="trackOutbound('https://example.com', 'Manual Test')">JS API</button>
            <a href="https://internal.test" data-insights-no-track target="_blank" class="btn btn-sm btn-gray">Skip Tracking →</a>
            <p class="info" style="margin-top:8px"><code>data-insights-no-track</code> prevents tracking</p>
        </div>

        <!-- Site Search Tests -->
        <div class="card">
            <h2><span>🔍</span> Site Searches <span class="tag tag-pro">PRO</span></h2>
            <p class="info">Track site search queries</p>
            <button class="btn-blue" onclick="trackSearch('craft cms', 15)">Search: craft cms (15 results)</button>
            <button class="btn-green" onclick="trackSearch('analytics', 8)">Search: analytics (8 results)</button>
            <button class="btn-purple" onclick="trackSearch('help')">Search: help (no results count)</button>
            <button class="btn-orange" onclick="trackSearch('nothing found', 0)">Search: nothing found (0 results)</button>
            <p class="info" style="margin-top:8px"><code>insights.trackSearch(query, resultsCount)</code></p>
        </div>

        <!-- Referrer Tests -->
        <div class="card">
            <h2><span>🔗</span> Referrer Simulation</h2>
            <p class="info">Open these links to test referrer tracking:</p>
            <div class="links test-links">
                <a href="https://www.google.com" target="_blank">Google →</a>
                <a href="https://www.facebook.com" target="_blank">Facebook →</a>
                <a href="https://www.twitter.com" target="_blank">Twitter →</a>
            </div>
            <p class="info" style="margin-top:12px">Then navigate back to this page from there.</p>
        </div>

        <!-- UTM Tests -->
        <div class="card">
            <h2><span>📢</span> UTM Parameters</h2>
            <p class="info">Test campaign tracking:</p>
            <div class="links">
                <a href="?utm_source=newsletter&utm_medium=email&utm_campaign=test" class="btn btn-sm btn-blue">Newsletter</a>
                <a href="?utm_source=google&utm_medium=cpc&utm_campaign=brand" class="btn btn-sm btn-green">Google Ads</a>
                <a href="?utm_source=facebook&utm_medium=social&utm_campaign=promo&utm_content=banner1" class="btn btn-sm btn-purple">Facebook Full</a>
            </div>
        </div>

        <!-- Screen Size Tests -->
        <div class="card">
            <h2><span>📱</span> Screen Size</h2>
            <p class="info">Current: <strong id="current-screen">-</strong></p>
            <p class="info">
                <code>s</code> = &lt;768px (mobile)<br>
                <code>m</code> = 768-1199px (tablet)<br>
                <code>l</code> = ≥1200px (desktop)
            </p>
            <button class="btn-gray btn-sm" onclick="location.reload()">Reload after resize</button>
        </div>

        <!-- Device Info -->
        <div class="card">
            <h2><span>💻</span> Device Detection</h2>
            <p class="info">User-Agent is parsed server-side:</p>
            <code style="font-size:11px;word-break:break-all" id="user-agent">-</code>
        </div>

        <!-- Bot Test -->
        <div class="card">
            <h2><span>🤖</span> Bot Filtering</h2>
            <p class="info">These requests will be blocked:</p>
            <button class="btn-red btn-sm" onclick="sendAsBot('googlebot')">As Googlebot</button>
            <button class="btn-red btn-sm" onclick="sendAsBot('lighthouse')">As Lighthouse</button>
            <p class="info" style="margin-top:8px">Expected: <code>status: "bot"</code></p>
        </div>

        <!-- DNT Test -->
        <div class="card">
            <h2><span>🛡️</span> Do Not Track</h2>
            <p class="info">DNT Header: <strong id="dnt-status">-</strong></p>
            <p class="info">If DNT=1 and enabled in settings, tracking is skipped.</p>
        </div>
    </div>

    <!-- Log -->
    <div class="card">
        <h2><span>📋</span> Request Log</h2>
        <div id="log"></div>
        <div style="margin-top:12px">
            <button class="btn-gray btn-sm" onclick="clearLog()">Clear</button>
            <button class="btn-blue btn-sm" onclick="sendPageview()">Quick Pageview</button>
            <button class="btn-purple btn-sm" onclick="trackEvent('quick_test', 'debug')">Quick Event</button>
        </div>
    </div>

    <!-- Quick Reference -->
    <div class="card">
        <h2><span>📖</span> Quick Reference</h2>
        <table>
            <tr><th>Type</th><th>Code</th><th>Description</th></tr>
            <tr><td><code>pv</code></td><td>Pageview</td><td>Page view</td></tr>
            <tr><td><code>en</code></td><td>Engagement</td><td>User interacted (scroll/click)</td></tr>
            <tr><td><code>lv</code></td><td>Leave</td><td>User leaves page (with duration)</td></tr>
            <tr><td><code>ev</code></td><td>Event</td><td>Custom event (Pro)</td></tr>
            <tr><td><code>ob</code></td><td>Outbound</td><td>External link click (Pro)</td></tr>
            <tr><td><code>sr</code></td><td>Search</td><td>Site search query (Pro)</td></tr>
        </table>
    </div>

<script>
(function() {
    var API = '/actions/insights/track';
    var logEl = document.getElementById('log');
    var startTime = Date.now();

    // Logging
    function log(type, msg, data) {
        var t = new Date().toLocaleTimeString();
        var cls = type === 'out' ? 'out' : type === 'err' ? 'err' : type === 'warn' ? 'warn' : 'in';
        var arrow = type === 'out' ? '→' : type === 'err' ? '✗' : type === 'warn' ? '⚠' : '←';
        var html = '<div><span class="time">[' + t + ']</span> <span class="' + cls + '">' + arrow + ' ' + msg + '</span>';
        if (data) html += ' <span style="color:#888">' + JSON.stringify(data) + '</span>';
        html += '</div>';
        logEl.innerHTML += html;
        logEl.scrollTop = logEl.scrollHeight;
    }

    window.clearLog = function() {
        logEl.innerHTML = '';
        log('in', 'Log cleared');
    };

    // URL Params
    function getParam(name) {
        try { return new URLSearchParams(location.search).get(name); }
        catch(e) { return null; }
    }

    // Screen category
    function getScreenCat() {
        var w = window.innerWidth;
        if (w < 768) return 's';
        if (w < 1200) return 'm';
        return 'l';
    }

    // Referrer domain
    function getRefDomain() {
        try {
            if (!document.referrer) return null;
            var url = new URL(document.referrer);
            if (url.hostname === location.hostname) return null;
            return url.hostname;
        } catch(e) { return null; }
    }

    // Base data
    function getData() {
        return {
            u: location.pathname,
            r: getRefDomain(),
            utm: {
                s: getParam('utm_source'),
                m: getParam('utm_medium'),
                c: getParam('utm_campaign'),
                t: getParam('utm_term'),
                n: getParam('utm_content')
            },
            sc: getScreenCat()
        };
    }

    // Send tracking
    function send(type, extra, customHeaders) {
        var data = Object.assign({ t: type }, getData(), extra || {});
        log('out', type.toUpperCase() + ' request', data);

        var headers = { 'Content-Type': 'application/json' };
        if (customHeaders) Object.assign(headers, customHeaders);

        fetch(API, {
            method: 'POST',
            body: JSON.stringify(data),
            headers: headers
        })
        .then(function(r) { return r.json(); })
        .then(function(r) {
            if (r.status === 'ok') {
                log('in', 'SUCCESS: ' + r.status);
            } else if (r.status === 'bot' || r.status === 'dnt' || r.status === 'disabled') {
                log('warn', 'BLOCKED: ' + r.status);
            } else if (r.status === 'pro_required') {
                log('warn', 'PRO REQUIRED: Event tracking is a Pro feature');
            } else {
                log('warn', 'Response: ' + r.status, r);
            }
        })
        .catch(function(e) { log('err', 'FAILED: ' + e.message); });
    }

    // Public functions
    window.sendPageview = function() { send('pv'); };
    window.sendEngagement = function() { send('en'); };
    window.sendLeave = function() {
        var time = Math.round((Date.now() - startTime) / 1000);
        send('lv', { tm: time });
    };

    window.trackEvent = function(name, category) {
        var extra = { name: name };
        if (category) extra.category = category;
        send('ev', extra);
    };

    window.trackOutbound = function(url, text) {
        var extra = { target: url };
        if (text) extra.text = text;
        send('ob', extra);
    };

    window.trackSearch = function(query, resultsCount) {
        var extra = { query: query };
        if (typeof resultsCount === 'number') extra.results = resultsCount;
        send('sr', extra);
    };

    window.sendAsBot = function(botName) {
        log('out', 'Sending as ' + botName + ' (simulated UA)');
        log('warn', 'Browser cannot change UA - test with curl:');
        log('in', 'curl -X POST ' + location.origin + API + ' -H "User-Agent: ' + botName + '" -d \'{"t":"pv","u":"/test"}\'');
    };

    // Auto event tracking
    document.addEventListener('click', function(e) {
        var el = e.target;
        while (el && el !== document) {
            var ev = el.getAttribute('data-insights-event');
            if (ev) {
                var cat = el.getAttribute('data-insights-category');
                trackEvent(ev, cat);
                break;
            }
            el = el.parentElement;
        }
    });

    // Auto outbound link tracking
    document.addEventListener('click', function(e) {
        var el = e.target;
        while (el && el !== document) {
            if (el.tagName === 'A' && el.href) {
                try {
                    var link = new URL(el.href, location.href);
                    // Check if external and not marked to skip
                    if (link.hostname !== location.hostname &&
                        (link.protocol === 'http:' || link.protocol === 'https:') &&
                        !el.hasAttribute('data-insights-no-track')) {
                        var text = (el.textContent || el.innerText || '').trim();
                        trackOutbound(el.href, text);
                    }
                } catch(err) {}
                break;
            }
            el = el.parentElement;
        }
    });

    // Init: Update detection display
    function updateDetection() {
        var data = getData();

        document.getElementById('det-url').textContent = data.u;
        document.getElementById('det-screen').textContent = data.sc + ' (' + window.innerWidth + 'px)';
        document.getElementById('current-screen').textContent = data.sc + ' (' + window.innerWidth + 'px)';
        document.getElementById('user-agent').textContent = navigator.userAgent;

        // Referrer
        var ref = document.getElementById('det-ref');
        var refStatus = document.getElementById('det-ref-status');
        if (data.r) {
            ref.textContent = data.r;
            refStatus.innerHTML = '<span style="color:green">✓ Will be tracked</span>';
            ref.parentElement.classList.add('detected');
        } else if (document.referrer) {
            ref.textContent = '(internal: ' + new URL(document.referrer).hostname + ')';
            refStatus.innerHTML = '<span style="color:gray">Ignored (same host)</span>';
        } else {
            ref.textContent = '(none)';
            refStatus.innerHTML = '<span style="color:gray">Direct visit</span>';
        }

        // UTM params
        ['s', 'm', 'c', 't', 'n'].forEach(function(key) {
            var val = data.utm[key];
            var el = document.getElementById('det-utm-' + key);
            var statusEl = document.getElementById('det-utm-' + key + '-status');
            if (val) {
                el.textContent = val;
                statusEl.innerHTML = '<span style="color:green">✓</span>';
                el.parentElement.classList.add('detected');
            } else {
                el.textContent = '(none)';
                statusEl.textContent = '-';
            }
        });

        // DNT
        var dnt = navigator.doNotTrack || window.doNotTrack;
        document.getElementById('dnt-status').textContent = dnt === '1' ? 'Enabled (1)' : 'Not set';
    }

    // Check connection
    function checkConnection() {
        fetch(API, {
            method: 'POST',
            body: JSON.stringify({ t: 'pv', u: '/connection-test', sc: 'm' }),
            headers: { 'Content-Type': 'application/json' }
        })
        .then(function(r) { return r.json(); })
        .then(function(r) {
            var dot = document.getElementById('dot-connection');
            var bar = document.getElementById('status-bar');
            if (r.status === 'ok') {
                dot.className = 'dot dot-green';
                bar.innerHTML = '<div><span class="dot dot-green"></span> Connected</div>' +
                    '<div>Endpoint: <code>' + API + '</code></div>' +
                    '<div>Status: <strong style="color:green">OK</strong></div>';
                log('in', 'Connection OK - Tracking is working');
            } else if (r.status === 'disabled') {
                dot.className = 'dot dot-yellow';
                bar.innerHTML = '<div><span class="dot dot-yellow"></span> Tracking Disabled</div>';
                log('warn', 'Tracking is disabled in plugin settings');
            } else {
                dot.className = 'dot dot-yellow';
                bar.innerHTML = '<div><span class="dot dot-yellow"></span> ' + r.status + '</div>';
                log('warn', 'Status: ' + r.status);
            }
        })
        .catch(function(e) {
            document.getElementById('dot-connection').className = 'dot dot-red';
            document.getElementById('status-bar').innerHTML = '<div><span class="dot dot-red"></span> Connection Failed</div>';
            log('err', 'Connection failed: ' + e.message);
        });
    }

    // Init
    updateDetection();
    checkConnection();
    log('in', 'Test suite ready');

})();
</script>
</body>
</html>
