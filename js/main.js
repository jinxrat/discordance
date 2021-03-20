/*!
    autosize 4.0.2
    license: MIT
    http://www.jacklmoore.com/autosize
*/
!function (e, t) { if ("function" == typeof define && define.amd) define(["module", "exports"], t); else if ("undefined" != typeof exports) t(module, exports); else { var n = { exports: {} }; t(n, n.exports), e.autosize = n.exports } }(this, function (e, t) { "use strict"; var n, o, p = "function" == typeof Map ? new Map : (n = [], o = [], { has: function (e) { return -1 < n.indexOf(e) }, get: function (e) { return o[n.indexOf(e)] }, set: function (e, t) { -1 === n.indexOf(e) && (n.push(e), o.push(t)) }, delete: function (e) { var t = n.indexOf(e); -1 < t && (n.splice(t, 1), o.splice(t, 1)) } }), c = function (e) { return new Event(e, { bubbles: !0 }) }; try { new Event("test") } catch (e) { c = function (e) { var t = document.createEvent("Event"); return t.initEvent(e, !0, !1), t } } function r(r) { if (r && r.nodeName && "TEXTAREA" === r.nodeName && !p.has(r)) { var e, n = null, o = null, i = null, d = function () { r.clientWidth !== o && a() }, l = function (t) { window.removeEventListener("resize", d, !1), r.removeEventListener("input", a, !1), r.removeEventListener("keyup", a, !1), r.removeEventListener("autosize:destroy", l, !1), r.removeEventListener("autosize:update", a, !1), Object.keys(t).forEach(function (e) { r.style[e] = t[e] }), p.delete(r) }.bind(r, { height: r.style.height, resize: r.style.resize, overflowY: r.style.overflowY, overflowX: r.style.overflowX, wordWrap: r.style.wordWrap }); r.addEventListener("autosize:destroy", l, !1), "onpropertychange" in r && "oninput" in r && r.addEventListener("keyup", a, !1), window.addEventListener("resize", d, !1), r.addEventListener("input", a, !1), r.addEventListener("autosize:update", a, !1), r.style.overflowX = "hidden", r.style.wordWrap = "break-word", p.set(r, { destroy: l, update: a }), "vertical" === (e = window.getComputedStyle(r, null)).resize ? r.style.resize = "none" : "both" === e.resize && (r.style.resize = "horizontal"), n = "content-box" === e.boxSizing ? -(parseFloat(e.paddingTop) + parseFloat(e.paddingBottom)) : parseFloat(e.borderTopWidth) + parseFloat(e.borderBottomWidth), isNaN(n) && (n = 0), a() } function s(e) { var t = r.style.width; r.style.width = "0px", r.offsetWidth, r.style.width = t, r.style.overflowY = e } function u() { if (0 !== r.scrollHeight) { var e = function (e) { for (var t = []; e && e.parentNode && e.parentNode instanceof Element;)e.parentNode.scrollTop && t.push({ node: e.parentNode, scrollTop: e.parentNode.scrollTop }), e = e.parentNode; return t }(r), t = document.documentElement && document.documentElement.scrollTop; r.style.height = "", r.style.height = r.scrollHeight + n + "px", o = r.clientWidth, e.forEach(function (e) { e.node.scrollTop = e.scrollTop }), t && (document.documentElement.scrollTop = t) } } function a() { u(); var e = Math.round(parseFloat(r.style.height)), t = window.getComputedStyle(r, null), n = "content-box" === t.boxSizing ? Math.round(parseFloat(t.height)) : r.offsetHeight; if (n < e ? "hidden" === t.overflowY && (s("scroll"), u(), n = "content-box" === t.boxSizing ? Math.round(parseFloat(window.getComputedStyle(r, null).height)) : r.offsetHeight) : "hidden" !== t.overflowY && (s("hidden"), u(), n = "content-box" === t.boxSizing ? Math.round(parseFloat(window.getComputedStyle(r, null).height)) : r.offsetHeight), i !== n) { i = n; var o = c("autosize:resized"); try { r.dispatchEvent(o) } catch (e) { } } } } function i(e) { var t = p.get(e); t && t.destroy() } function d(e) { var t = p.get(e); t && t.update() } var l = null; "undefined" == typeof window || "function" != typeof window.getComputedStyle ? ((l = function (e) { return e }).destroy = function (e) { return e }, l.update = function (e) { return e }) : ((l = function (e, t) { return e && Array.prototype.forEach.call(e.length ? e : [e], function (e) { return r(e) }), e }).destroy = function (e) { return e && Array.prototype.forEach.call(e.length ? e : [e], i), e }, l.update = function (e) { return e && Array.prototype.forEach.call(e.length ? e : [e], d), e }), t.default = l, e.exports = t.default });

/* https://stackoverflow.com/a/11077016 */
function insertAtCursor(el, value) {
    // IE support
    if (document.selection) {
        el.focus()
        sel = document.selection.createRange()
        sel.text = value
    }
    // Modern browsers
    else if (el.selectionStart || el.selectionStart === 0) {
        let startPos = el.selectionStart
        let endPos = el.selectionEnd
        el.value = el.value.substring(0, startPos)
            + value
            + el.value.substring(endPos, el.value.length)
    } else {
        el.value += value
    }
    el.dispatchEvent(new KeyboardEvent("keyup"))
}

/* Position the tooltip */
function positionTooltip(parent, tooltip, padding = 5) {
    const parentCoords = parent.getBoundingClientRect()
    const tooltipCoords = tooltip.getBoundingClientRect()
    const left = Math.round(parentCoords.left - ((tooltipCoords.width - parentCoords.width) / 2))
    const top = parentCoords.top - (tooltipCoords.height + padding)
    tooltip.style.left = `${left}px`
    tooltip.style.top = `${top}px`
}

/* Main Discordance JS */
(function () {
    const form = document.querySelector("form")
    const webhooks = document.querySelector("#webhooks")
    const format_warn = document.querySelector("#format-warn")
    const format = document.querySelector("#format")
    const pretty = document.querySelector("#pretty")
    const submit = document.querySelector("#submit")
    webhooks.addEventListener("keyup", function (e) {
        e.preventDefault()
        webhooks.value = webhooks.value
            .replace(/\s|\,/g, "\n")
    })
    format.addEventListener("keyup", function (e) {
        e.preventDefault()
        try {
            JSON.parse(format.value)
            format_warn.style.opacity = 0
            if (submit.hasAttribute("disabled")) {
                submit.removeAttribute("disabled")
            }
        } catch (err) {
            format_warn.style.opacity = 1
            if (!submit.hasAttribute("disabled")) {
                submit.setAttribute("disabled", true)
            }
        }
    })
    pretty.addEventListener("click", function (e) {
        e.preventDefault()
        try {
            format.value = JSON.stringify(JSON.parse(format.value), null, 4)
        } catch (err) {
            return
        }
    })
    form.addEventListener("submit", function (e) {
        const valid_webhooks = new Set()
        webhooks.value
            .split("\n")
            .filter(v => /^(https\:\/\/(www\.)?discord\.com\/api\/webhooks\/([0-9]+)\/([a-zA-Z0-9_-]+))/.test(v))
            .map(v => valid_webhooks.add(v))
        webhooks.value = Array.from(valid_webhooks).join("\n")
        pretty.click()
        return true
    })
    autosize(document.querySelectorAll("textarea"))
    const variables = document.querySelectorAll("#helper .variables span.button")
    variables.forEach(variable => {
        variable.addEventListener("mouseover", function (e) {
            positionTooltip(e.currentTarget, e.currentTarget.querySelector("span"), 0)
        })
        variable.addEventListener("click", function (e) {
            insertAtCursor(format, e.currentTarget.innerHTML.replace(/(%.*%).*/, '$1'))
        })
    })
})()