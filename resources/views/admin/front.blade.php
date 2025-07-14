<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="WbOhY6LmjYcxSeV6XQkHmTUgatonj57icH2Ztx2v" />
    <title>Digital Epalika</title>
    <link rel="stylesheet" href="https://demoerp.palikaerp.com/assets/frontend/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://demoerp.palikaerp.com/assets/frontend/css/style.css" />
    <link rel="stylesheet" href="https://demoerp.palikaerp.com/assets/frontend/css/utils.css" />
    <link rel="stylesheet" href="https://demoerp.palikaerp.com/assets/frontend/css/owl/owl.carousel.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Mukta:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://demoerp.palikaerp.com/assets/backend/css/plugins/datepicker.min.css">

    <!-- Livewire Styles -->
    <style>
        [wire\:loading],
        [wire\:loading\.delay],
        [wire\:loading\.inline-block],
        [wire\:loading\.inline],
        [wire\:loading\.block],
        [wire\:loading\.flex],
        [wire\:loading\.table],
        [wire\:loading\.grid],
        [wire\:loading\.inline-flex] {
            display: none;
        }

        [wire\:loading\.delay\.shortest],
        [wire\:loading\.delay\.shorter],
        [wire\:loading\.delay\.short],
        [wire\:loading\.delay\.long],
        [wire\:loading\.delay\.longer],
        [wire\:loading\.delay\.longest] {
            display: none;
        }

        [wire\:offline] {
            display: none;
        }

        [wire\:dirty]:not(textarea):not(input):not(select) {
            display: none;
        }

        input:-webkit-autofill,
        select:-webkit-autofill,
        textarea:-webkit-autofill {
            animation-duration: 50000s;
            animation-name: livewireautofill;
        }

        @keyframes livewireautofill {
            from {}
        }
    </style>

    <style>
        .modal-content {
            min-height: auto;
            border: 0;
            background-color: #ffffff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
        }
    </style>
    <link rel="stylesheet" href="{{asset('custom.css')}}">
    <link rel='stylesheet' type='text/css' property='stylesheet'
        href='//demoerp.palikaerp.com/_debugbar/assets/stylesheets?v=1697098252&theme=auto' data-turbolinks-eval='false'
        data-turbo-eval='false'>
    <script src='//demoerp.palikaerp.com/_debugbar/assets/javascript?v=1697098252' data-turbolinks-eval='false'
        data-turbo-eval='false'></script>
    <script data-turbo-eval="false">
        jQuery.noConflict(true);
    </script>
    <script>
        Sfdump = window.Sfdump || (function(doc) {
            doc.documentElement.classList.add('sf-js-enabled');
            var rxEsc = /([.*+?^${}()|\[\]\/\\])/g,
                idRx = /\bsf-dump-\d+-ref[012]\w+\b/,
                keyHint = 0 <= navigator.platform.toUpperCase().indexOf('MAC') ? 'Cmd' : 'Ctrl',
                addEventListener = function(e, n, cb) {
                    e.addEventListener(n, cb, false);
                };
            if (!doc.addEventListener) {
                addEventListener = function(element, eventName, callback) {
                    element.attachEvent('on' + eventName, function(e) {
                        e.preventDefault = function() {
                            e.returnValue = false;
                        };
                        e.target = e.srcElement;
                        callback(e);
                    });
                };
            }

            function toggle(a, recursive) {
                var s = a.nextSibling || {},
                    oldClass = s.className,
                    arrow, newClass;
                if (/\bsf-dump-compact\b/.test(oldClass)) {
                    arrow = '▼';
                    newClass = 'sf-dump-expanded';
                } else if (/\bsf-dump-expanded\b/.test(oldClass)) {
                    arrow = '▶';
                    newClass = 'sf-dump-compact';
                } else {
                    return false;
                }
                if (doc.createEvent && s.dispatchEvent) {
                    var event = doc.createEvent('Event');
                    event.initEvent('sf-dump-expanded' === newClass ? 'sfbeforedumpexpand' : 'sfbeforedumpcollapse',
                        true, false);
                    s.dispatchEvent(event);
                }
                a.lastChild.innerHTML = arrow;
                s.className = s.className.replace(/\bsf-dump-(compact|expanded)\b/, newClass);
                if (recursive) {
                    try {
                        a = s.querySelectorAll('.' + oldClass);
                        for (s = 0; s < a.length; ++s) {
                            if (-1 == a[s].className.indexOf(newClass)) {
                                a[s].className = newClass;
                                a[s].previousSibling.lastChild.innerHTML = arrow;
                            }
                        }
                    } catch (e) {}
                }
                return true;
            };

            function collapse(a, recursive) {
                var s = a.nextSibling || {},
                    oldClass = s.className;
                if (/\bsf-dump-expanded\b/.test(oldClass)) {
                    toggle(a, recursive);
                    return true;
                }
                return false;
            };

            function expand(a, recursive) {
                var s = a.nextSibling || {},
                    oldClass = s.className;
                if (/\bsf-dump-compact\b/.test(oldClass)) {
                    toggle(a, recursive);
                    return true;
                }
                return false;
            };

            function collapseAll(root) {
                var a = root.querySelector('a.sf-dump-toggle');
                if (a) {
                    collapse(a, true);
                    expand(a);
                    return true;
                }
                return false;
            }

            function reveal(node) {
                var previous, parents = [];
                while ((node = node.parentNode || {}) && (previous = node.previousSibling) && 'A' === previous
                    .tagName) {
                    parents.push(previous);
                }
                if (0 !== parents.length) {
                    parents.forEach(function(parent) {
                        expand(parent);
                    });
                    return true;
                }
                return false;
            }

            function highlight(root, activeNode, nodes) {
                resetHighlightedNodes(root);
                Array.from(nodes || []).forEach(function(node) {
                    if (!/\bsf-dump-highlight\b/.test(node.className)) {
                        node.className = node.className + ' sf-dump-highlight';
                    }
                });
                if (!/\bsf-dump-highlight-active\b/.test(activeNode.className)) {
                    activeNode.className = activeNode.className + ' sf-dump-highlight-active';
                }
            }

            function resetHighlightedNodes(root) {
                Array.from(root.querySelectorAll(
                        '.sf-dump-str, .sf-dump-key, .sf-dump-public, .sf-dump-protected, .sf-dump-private'))
                    .forEach(function(strNode) {
                        strNode.className = strNode.className.replace(/\bsf-dump-highlight\b/, '');
                        strNode.className = strNode.className.replace(/\bsf-dump-highlight-active\b/, '');
                    });
            }
            return function(root, x) {
                root = doc.getElementById(root);
                var indentRx = new RegExp('^(' + (root.getAttribute('data-indent-pad') || ' ').replace(rxEsc,
                        '\\$1') + ')+', 'm'),
                    options = {
                        "maxDepth": 1,
                        "maxStringLength": 160,
                        "fileLinkFormat": false
                    },
                    elt = root.getElementsByTagName('A'),
                    len = elt.length,
                    i = 0,
                    s, h, t = [];
                while (i < len) t.push(elt[i++]);
                for (i in x) {
                    options[i] = x[i];
                }

                function a(e, f) {
                    addEventListener(root, e, function(e, n) {
                        if ('A' == e.target.tagName) {
                            f(e.target, e);
                        } else if ('A' == e.target.parentNode.tagName) {
                            f(e.target.parentNode, e);
                        } else {
                            n = /\bsf-dump-ellipsis\b/.test(e.target.className) ? e.target.parentNode :
                                e.target;
                            if ((n = n.nextElementSibling) && 'A' == n.tagName) {
                                if (!/\bsf-dump-toggle\b/.test(n.className)) {
                                    n = n.nextElementSibling || n;
                                }
                                f(n, e, true);
                            }
                        }
                    });
                };

                function isCtrlKey(e) {
                    return e.ctrlKey || e.metaKey;
                }

                function xpathString(str) {
                    var parts = str.match(/[^'"]+|['"]/g).map(function(part) {
                        if ("'" == part) {
                            return '"\'"';
                        }
                        if ('"' == part) {
                            return "'\"'";
                        }
                        return "'" + part + "'";
                    });
                    return "concat(" + parts.join(",") + ", '')";
                }

                function xpathHasClass(className) {
                    return "contains(concat(' ', normalize-space(@class), ' '), ' " + className + " ')";
                }
                a('mouseover', function(a, e, c) {
                    if (c) {
                        e.target.style.cursor = "pointer";
                    }
                });
                a('click', function(a, e, c) {
                    if (/\bsf-dump-toggle\b/.test(a.className)) {
                        e.preventDefault();
                        if (!toggle(a, isCtrlKey(e))) {
                            var r = doc.getElementById(a.getAttribute('href').slice(1)),
                                s = r.previousSibling,
                                f = r.parentNode,
                                t = a.parentNode;
                            t.replaceChild(r, a);
                            f.replaceChild(a, s);
                            t.insertBefore(s, r);
                            f = f.firstChild.nodeValue.match(indentRx);
                            t = t.firstChild.nodeValue.match(indentRx);
                            if (f && t && f[0] !== t[0]) {
                                r.innerHTML = r.innerHTML.replace(new RegExp('^' + f[0].replace(rxEsc,
                                    '\\$1'), 'mg'), t[0]);
                            }
                            if (/\bsf-dump-compact\b/.test(r.className)) {
                                toggle(s, isCtrlKey(e));
                            }
                        }
                        if (c) {} else if (doc.getSelection) {
                            try {
                                doc.getSelection().removeAllRanges();
                            } catch (e) {
                                doc.getSelection().empty();
                            }
                        } else {
                            doc.selection.empty();
                        }
                    } else if (/\bsf-dump-str-toggle\b/.test(a.className)) {
                        e.preventDefault();
                        e = a.parentNode.parentNode;
                        e.className = e.className.replace(/\bsf-dump-str-(expand|collapse)\b/, a
                            .parentNode.className);
                    }
                });
                elt = root.getElementsByTagName('SAMP');
                len = elt.length;
                i = 0;
                while (i < len) t.push(elt[i++]);
                len = t.length;
                for (i = 0; i < len; ++i) {
                    elt = t[i];
                    if ('SAMP' == elt.tagName) {
                        a = elt.previousSibling || {};
                        if ('A' != a.tagName) {
                            a = doc.createElement('A');
                            a.className = 'sf-dump-ref';
                            elt.parentNode.insertBefore(a, elt);
                        } else {
                            a.innerHTML += ' ';
                        }
                        a.title = (a.title ? a.title + '\n[' : '[') + keyHint + '+click] Expand all children';
                        a.innerHTML += elt.className == 'sf-dump-compact' ? '<span>▶</span>' : '<span>▼</span>';
                        a.className += ' sf-dump-toggle';
                        x = 1;
                        if ('sf-dump' != elt.parentNode.className) {
                            x += elt.parentNode.getAttribute('data-depth') / 1;
                        }
                    } else if (/\bsf-dump-ref\b/.test(elt.className) && (a = elt.getAttribute('href'))) {
                        a = a.slice(1);
                        elt.className += ' sf-dump-hover';
                        elt.className += ' ' + a;
                        if (/[\[{]$/.test(elt.previousSibling.nodeValue)) {
                            a = a != elt.nextSibling.id && doc.getElementById(a);
                            try {
                                s = a.nextSibling;
                                elt.appendChild(a);
                                s.parentNode.insertBefore(a, s);
                                if (/^[@#]/.test(elt.innerHTML)) {
                                    elt.innerHTML += ' <span>▶</span>';
                                } else {
                                    elt.innerHTML = '<span>▶</span>';
                                    elt.className = 'sf-dump-ref';
                                }
                                elt.className += ' sf-dump-toggle';
                            } catch (e) {
                                if ('&' == elt.innerHTML.charAt(0)) {
                                    elt.innerHTML = '…';
                                    elt.className = 'sf-dump-ref';
                                }
                            }
                        }
                    }
                }
                if (doc.evaluate && Array.from && root.children.length > 1) {
                    root.setAttribute('tabindex', 0);
                    SearchState = function() {
                        this.nodes = [];
                        this.idx = 0;
                    };
                    SearchState.prototype = {
                        next: function() {
                            if (this.isEmpty()) {
                                return this.current();
                            }
                            this.idx = this.idx < (this.nodes.length - 1) ? this.idx + 1 : 0;
                            return this.current();
                        },
                        previous: function() {
                            if (this.isEmpty()) {
                                return this.current();
                            }
                            this.idx = this.idx > 0 ? this.idx - 1 : (this.nodes.length - 1);
                            return this.current();
                        },
                        isEmpty: function() {
                            return 0 === this.count();
                        },
                        current: function() {
                            if (this.isEmpty()) {
                                return null;
                            }
                            return this.nodes[this.idx];
                        },
                        reset: function() {
                            this.nodes = [];
                            this.idx = 0;
                        },
                        count: function() {
                            return this.nodes.length;
                        },
                    };

                    function showCurrent(state) {
                        var currentNode = state.current(),
                            currentRect, searchRect;
                        if (currentNode) {
                            reveal(currentNode);
                            highlight(root, currentNode, state.nodes);
                            if ('scrollIntoView' in currentNode) {
                                currentNode.scrollIntoView(true);
                                currentRect = currentNode.getBoundingClientRect();
                                searchRect = search.getBoundingClientRect();
                                if (currentRect.top < (searchRect.top + searchRect.height)) {
                                    window.scrollBy(0, -(searchRect.top + searchRect.height + 5));
                                }
                            }
                        }
                        counter.textContent = (state.isEmpty() ? 0 : state.idx + 1) + ' of ' + state.count();
                    }
                    var search = doc.createElement('div');
                    search.className = 'sf-dump-search-wrapper sf-dump-search-hidden';
                    search.innerHTML =
                        ' <input type="text" class="sf-dump-search-input"> <span class="sf-dump-search-count">0 of 0<\/span> <button type="button" class="sf-dump-search-input-previous" tabindex="-1"> <svg viewBox="0 0 1792 1792" xmlns="http://www.w3.org/2000/svg"><path d="M1683 1331l-166 165q-19 19-45 19t-45-19L896 965l-531 531q-19 19-45 19t-45-19l-166-165q-19-19-19-45.5t19-45.5l742-741q19-19 45-19t45 19l742 741q19 19 19 45.5t-19 45.5z"\/><\/svg> <\/button> <button type="button" class="sf-dump-search-input-next" tabindex="-1"> <svg viewBox="0 0 1792 1792" xmlns="http://www.w3.org/2000/svg"><path d="M1683 808l-742 741q-19 19-45 19t-45-19L109 808q-19-19-19-45.5t19-45.5l166-165q19-19 45-19t45 19l531 531 531-531q19-19 45-19t45 19l166 165q19 19 19 45.5t-19 45.5z"\/><\/svg> <\/button> ';
                    root.insertBefore(search, root.firstChild);
                    var state = new SearchState();
                    var searchInput = search.querySelector('.sf-dump-search-input');
                    var counter = search.querySelector('.sf-dump-search-count');
                    var searchInputTimer = 0;
                    var previousSearchQuery = '';
                    addEventListener(searchInput, 'keyup', function(e) {
                        var searchQuery = e.target
                        .value; /* Don't perform anything if the pressed key didn't change the query */
                        if (searchQuery === previousSearchQuery) {
                            return;
                        }
                        previousSearchQuery = searchQuery;
                        clearTimeout(searchInputTimer);
                        searchInputTimer = setTimeout(function() {
                            state.reset();
                            collapseAll(root);
                            resetHighlightedNodes(root);
                            if ('' === searchQuery) {
                                counter.textContent = '0 of 0';
                                return;
                            }
                            var classMatches = ["sf-dump-str", "sf-dump-key", "sf-dump-public",
                                "sf-dump-protected", "sf-dump-private",
                            ].map(xpathHasClass).join(' or ');
                            var xpathResult = doc.evaluate('.//span[' + classMatches +
                                '][contains(translate(child::text(), ' + xpathString(
                                    searchQuery.toUpperCase()) + ', ' + xpathString(
                                    searchQuery.toLowerCase()) + '), ' + xpathString(
                                    searchQuery.toLowerCase()) + ')]', root, null,
                                XPathResult.ORDERED_NODE_ITERATOR_TYPE, null);
                            while (node = xpathResult.iterateNext()) state.nodes.push(node);
                            showCurrent(state);
                        }, 400);
                    });
                    Array.from(search.querySelectorAll(
                        '.sf-dump-search-input-next, .sf-dump-search-input-previous')).forEach(function(
                    btn) {
                        addEventListener(btn, 'click', function(e) {
                            e.preventDefault(); - 1 !== e.target.className.indexOf('next') ?
                                state.next() : state.previous();
                            searchInput.focus();
                            collapseAll(root);
                            showCurrent(state);
                        })
                    });
                    addEventListener(root, 'keydown', function(e) {
                        var isSearchActive = !/\bsf-dump-search-hidden\b/.test(search.className);
                        if ((114 === e.keyCode && !isSearchActive) || (isCtrlKey(e) && 70 === e
                            .keyCode)) {
                            /* F3 or CMD/CTRL + F */
                            if (70 === e.keyCode && document.activeElement === searchInput) {
                                /* * If CMD/CTRL + F is hit while having focus on search input, * the user probably meant to trigger browser search instead. * Let the browser execute its behavior: */
                                return;
                            }
                            e.preventDefault();
                            search.className = search.className.replace(/\bsf-dump-search-hidden\b/,
                            '');
                            searchInput.focus();
                        } else if (isSearchActive) {
                            if (27 === e.keyCode) {
                                /* ESC key */
                                search.className += ' sf-dump-search-hidden';
                                e.preventDefault();
                                resetHighlightedNodes(root);
                                searchInput.value = '';
                            } else if ((isCtrlKey(e) && 71 === e.keyCode) /* CMD/CTRL + G */ || 13 === e
                                .keyCode /* Enter */ || 114 === e.keyCode /* F3 */ ) {
                                e.preventDefault();
                                e.shiftKey ? state.previous() : state.next();
                                collapseAll(root);
                                showCurrent(state);
                            }
                        }
                    });
                }
                if (0 >= options.maxStringLength) {
                    return;
                }
                try {
                    elt = root.querySelectorAll('.sf-dump-str');
                    len = elt.length;
                    i = 0;
                    t = [];
                    while (i < len) t.push(elt[i++]);
                    len = t.length;
                    for (i = 0; i < len; ++i) {
                        elt = t[i];
                        s = elt.innerText || elt.textContent;
                        x = s.length - options.maxStringLength;
                        if (0 < x) {
                            h = elt.innerHTML;
                            elt[elt.innerText ? 'innerText' : 'textContent'] = s.substring(0, options
                                .maxStringLength);
                            elt.className += ' sf-dump-str-collapse';
                            elt.innerHTML = '<span class=sf-dump-str-collapse>' + h +
                                '<a class="sf-dump-ref sf-dump-str-toggle" title="Collapse"> ◀</a></span>' +
                                '<span class=sf-dump-str-expand>' + elt.innerHTML +
                                '<a class="sf-dump-ref sf-dump-str-toggle" title="' + x +
                                ' remaining characters"> ▶</a></span>';
                        }
                    }
                } catch (e) {}
            };
        })(document);
    </script>
    <style>
        .sf-js-enabled .phpdebugbar pre.sf-dump .sf-dump-compact,
        .sf-js-enabled .sf-dump-str-collapse .sf-dump-str-collapse,
        .sf-js-enabled .sf-dump-str-expand .sf-dump-str-expand {
            display: none;
        }

        .sf-dump-hover:hover {
            background-color: #B729D9;
            color: #FFF !important;
            border-radius: 2px;
        }

        .phpdebugbar pre.sf-dump {
            display: block;
            white-space: pre;
            padding: 5px;
            overflow: initial !important;
        }

        .phpdebugbar pre.sf-dump:after {
            content: "";
            visibility: hidden;
            display: block;
            height: 0;
            clear: both;
        }

        .phpdebugbar pre.sf-dump span {
            display: inline;
        }

        .phpdebugbar pre.sf-dump a {
            text-decoration: none;
            cursor: pointer;
            border: 0;
            outline: none;
            color: inherit;
        }

        .phpdebugbar pre.sf-dump img {
            max-width: 50em;
            max-height: 50em;
            margin: .5em 0 0 0;
            padding: 0;
            background: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAAAAAA6mKC9AAAAHUlEQVQY02O8zAABilCaiQEN0EeA8QuUcX9g3QEAAjcC5piyhyEAAAAASUVORK5CYII=) #D3D3D3;
        }

        .phpdebugbar pre.sf-dump .sf-dump-ellipsis {
            display: inline-block;
            overflow: visible;
            text-overflow: ellipsis;
            max-width: 5em;
            white-space: nowrap;
            overflow: hidden;
            vertical-align: top;
        }

        .phpdebugbar pre.sf-dump .sf-dump-ellipsis+.sf-dump-ellipsis {
            max-width: none;
        }

        .phpdebugbar pre.sf-dump code {
            display: inline;
            padding: 0;
            background: none;
        }

        .sf-dump-public.sf-dump-highlight,
        .sf-dump-protected.sf-dump-highlight,
        .sf-dump-private.sf-dump-highlight,
        .sf-dump-str.sf-dump-highlight,
        .sf-dump-key.sf-dump-highlight {
            background: rgba(111, 172, 204, 0.3);
            border: 1px solid #7DA0B1;
            border-radius: 3px;
        }

        .sf-dump-public.sf-dump-highlight-active,
        .sf-dump-protected.sf-dump-highlight-active,
        .sf-dump-private.sf-dump-highlight-active,
        .sf-dump-str.sf-dump-highlight-active,
        .sf-dump-key.sf-dump-highlight-active {
            background: rgba(253, 175, 0, 0.4);
            border: 1px solid #ffa500;
            border-radius: 3px;
        }

        .phpdebugbar pre.sf-dump .sf-dump-search-hidden {
            display: none !important;
        }

        .phpdebugbar pre.sf-dump .sf-dump-search-wrapper {
            font-size: 0;
            white-space: nowrap;
            margin-bottom: 5px;
            display: flex;
            position: -webkit-sticky;
            position: sticky;
            top: 5px;
        }

        .phpdebugbar pre.sf-dump .sf-dump-search-wrapper>* {
            vertical-align: top;
            box-sizing: border-box;
            height: 21px;
            font-weight: normal;
            border-radius: 0;
            background: #FFF;
            color: #757575;
            border: 1px solid #BBB;
        }

        .phpdebugbar pre.sf-dump .sf-dump-search-wrapper>input.sf-dump-search-input {
            padding: 3px;
            height: 21px;
            font-size: 12px;
            border-right: none;
            border-top-left-radius: 3px;
            border-bottom-left-radius: 3px;
            color: #000;
            min-width: 15px;
            width: 100%;
        }

        .phpdebugbar pre.sf-dump .sf-dump-search-wrapper>.sf-dump-search-input-next,
        .phpdebugbar pre.sf-dump .sf-dump-search-wrapper>.sf-dump-search-input-previous {
            background: #F2F2F2;
            outline: none;
            border-left: none;
            font-size: 0;
            line-height: 0;
        }

        .phpdebugbar pre.sf-dump .sf-dump-search-wrapper>.sf-dump-search-input-next {
            border-top-right-radius: 3px;
            border-bottom-right-radius: 3px;
        }

        .phpdebugbar pre.sf-dump .sf-dump-search-wrapper>.sf-dump-search-input-next>svg,
        .phpdebugbar pre.sf-dump .sf-dump-search-wrapper>.sf-dump-search-input-previous>svg {
            pointer-events: none;
            width: 12px;
            height: 12px;
        }

        .phpdebugbar pre.sf-dump .sf-dump-search-wrapper>.sf-dump-search-count {
            display: inline-block;
            padding: 0 5px;
            margin: 0;
            border-left: none;
            line-height: 21px;
            font-size: 12px;
        }

        .phpdebugbar pre.sf-dump,
        .phpdebugbar pre.sf-dump .sf-dump-default {
            word-wrap: break-word;
            white-space: pre-wrap;
            word-break: normal
        }

        .phpdebugbar pre.sf-dump .sf-dump-num {
            font-weight: bold;
            color: #1299DA
        }

        .phpdebugbar pre.sf-dump .sf-dump-const {
            font-weight: bold
        }

        .phpdebugbar pre.sf-dump .sf-dump-str {
            font-weight: bold;
            color: #3A9B26
        }

        .phpdebugbar pre.sf-dump .sf-dump-note {
            color: #1299DA
        }

        .phpdebugbar pre.sf-dump .sf-dump-ref {
            color: #7B7B7B
        }

        .phpdebugbar pre.sf-dump .sf-dump-public {
            color: #000000
        }

        .phpdebugbar pre.sf-dump .sf-dump-protected {
            color: #000000
        }

        .phpdebugbar pre.sf-dump .sf-dump-private {
            color: #000000
        }

        .phpdebugbar pre.sf-dump .sf-dump-meta {
            color: #B729D9
        }

        .phpdebugbar pre.sf-dump .sf-dump-key {
            color: #3A9B26
        }

        .phpdebugbar pre.sf-dump .sf-dump-index {
            color: #1299DA
        }

        .phpdebugbar pre.sf-dump .sf-dump-ellipsis {
            color: #A0A000
        }

        .phpdebugbar pre.sf-dump .sf-dump-ns {
            user-select: none;
        }

        .phpdebugbar pre.sf-dump .sf-dump-ellipsis-note {
            color: #1299DA
        }
    </style>
</head>

<body>

    <div class="background module-header" style="background-image: url('')">
        <div class="container-fluid d-lg-flex justify-content-between align-items-center">
            <div class="d-flex gap-2 align-items-center">
                <a href="https://demoerp.palikaerp.com" class="main-logo">
                    <img alt="nepal-government-logo" class="logo img-responsive center-block d-block mx-auto"
                        src="https://demoerp.palikaerp.com/assets/frontend/image/logo.png" />
                </a>
                <div class="main-heading">
                    <div class="sub-title mb-1">
                        <span style="color: #ffffff; font-size: 2 !important;">ललितपुर नगरपालिकाको कार्यालय</span>
                        <span class="d-block" style="color: #ffffff; font-size: 2!important;">ललितपुर नगरपालिका</span>
                        <span class="d-block" style="color: #fffafa; font-size: 1!important;">ललितपुर</span>
                    </div>

                </div>
            </div>
            <div class="d-flex align-items-center">

                <a href="{{ route('digital-service') }}"
                    class="me-3 text-white text-decoration-underline">विधुतीय शुसासन
                    सेवा</a>
                <a href="#" class="main-logo d-flex align-items-center"
                    style="text-decoration: none">
                    <img alt="nepal-flag" class="logo img-responsive center-block ms-2 bg-white"
                        src="https://demoerp.palikaerp.com/assets/frontend/image/nepal_flag.gif"
                        style="height: 35px; padding: 2px; border-radius: 4px; border-top-right-radius: 0; border-bottom-right-radius: 0" />
                    <span class="fw-bold"
                        style="display: inline-flex;
                    justify-content: center;
                    align-items: center;
                    padding: 5px 15px;
                    background: transparent;
                    border: 1px solid #fff;
                    color: #fff;
                    border-top-left-radius: 0 !important;
                    border-bottom-left-radius: 0 !important;
                    margin-left: 0px;
                    border-radius: 5px;">


                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-calendar-week" viewBox="0 0 16 16">
                            <path
                                d="M11 6.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm-3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm-5 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5z" />
                            <path
                                d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5M1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4z" />
                        </svg>&nbsp;&nbsp;
                        <span class="date-text">
                            २०८१-०८-०५
                        </span>
                        &nbsp;
                        15:48:08 </span>
                </a>
                <a href="tel:०८१५३६३३८" class="main-logo d-flex align-items-center" style="text-decoration: none">
                    <span class="fw-bold"
                        style="display: inline-flex;
                    justify-content: center;
                    align-items: center;
                    padding: 5px 15px;
                    background: transparent;
                    border: 1px solid #fff;
                    color: #fff;
                    margin-left: 7px;
                    border-radius: 5px;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-telephone" viewBox="0 0 16 16">
                            <path
                                d="M3.654 1.328a.678.678 0 0 0-1.015-.063L1.605 2.3c-.483.484-.661 1.169-.45 1.77a17.568 17.568 0 0 0 4.168 6.608 17.569 17.569 0 0 0 6.608 4.168c.601.211 1.286.033 1.77-.45l1.034-1.034a.678.678 0 0 0-.063-1.015l-2.307-1.794a.678.678 0 0 0-.58-.122l-2.19.547a1.745 1.745 0 0 1-1.657-.459L5.482 8.062a1.745 1.745 0 0 1-.46-1.657l.548-2.19a.678.678 0 0 0-.122-.58L3.654 1.328zM1.884.511a1.745 1.745 0 0 1 2.612.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.678.678 0 0 0 .178.643l2.457 2.457a.678.678 0 0 0 .644.178l2.189-.547a1.745 1.745 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.634 18.634 0 0 1-7.01-4.42 18.634 18.634 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877L1.885.511z" />
                        </svg>&nbsp;&nbsp;
                        फोन नं - </span>
                </a>
                <a href="mailto:" class="main-logo d-flex align-items-center" style="text-decoration: none">
                    <span class="fw-bold"
                        style="display: inline-flex; justify-content: center; align-items: center; padding: 5px 15px; background: transparent; border: 1px solid #fff; color: #fff; margin-left: 7px; border-radius: 5px;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-envelope" viewBox="0 0 16 16">
                            <path
                                d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4zM.05 4.555L8 9.615l7.95-5.06A1 1 0 0 0 15 4H1a1 1 0 0 0-.95.555zM16 4.697l-7.823 4.978a.5.5 0 0 1-.354.075h-.646a.5.5 0 0 1-.354-.075L0 4.697V12a1 1 0 0 0 1 1h14a1 1 0 0 0 1-1V4.697z" />
                        </svg>&nbsp;&nbsp;
                        ईमेल-
                    </span>
                </a>
            </div>
        </div>
        <div class="bg-overlay"></div>
    </div>

    <main>
        <section>
            <div class="news-slider-wrapper">
                <div class="d-flex align-items-center w-100">
                    <h2>सूचना</h2>
                    <marquee class="w-100" behavior="scroll" scrolldelay="100" scrollamount="6">
                        <ul class="d-flex gap-5">
                            <li class="mr-5 ">
                                Fiscal Year 2081/2082 Budget book
                            </li>
                            <li class="mr-5 ">
                                LISA २०७९/८० को नतिजा
                            </li>
                            <li class="mr-5 ">
                                दर्ता सहयोगीको लागि दरखास्त आव्हान सम्बन्धी सूचना।
                            </li>
                            <li class="mr-5 ">
                                लिखित परीक्षाको नतिजा तथा अन्तर्वार्ता सम्बन्धी सूचना।
                            </li>
                            <li class="mr-5 ">
                                तह वृद्धिको लागि दरखास्त आव्हान सूचना।
                            </li>
                            <li class="mr-5 ">
                                पशु सेवा शाखाको सूचना!!!
                            </li>
                            <li class="mr-5 ">
                                नगर प्रहरी पदको लिखित परीक्षा सम्बन्धी सूचना!!!
                            </li>
                            <li class="mr-5 ">
                                सेवा स्थगित बारे सूचना!!!
                            </li>
                            <li class="mr-5 ">
                                सूचना!!
                            </li>
                            <li class="mr-5 ">
                                आ.व. ०७९/८० को यथार्थ आन्तरिक आय विवरण
                            </li>
                            <li class="mr-5 ">
                                पशु सेवा शाखाको सूचना!
                            </li>
                            <li class="mr-5 ">
                                प्रस्तावना पेश गरे सूचना
                            </li>
                            <li class="mr-5 ">
                                सेवा करारमा भाषा सहजकर्ता/सह शिक्षक पदपूर्ति सम्बन्धी सूचना!
                            </li>
                            <li class="mr-5 ">
                                अनितिम नतिजा प्रकाशन गरिएको सूचना!
                            </li>
                            <li class="mr-5 ">
                                लिखित परीक्षाको नतिजाको पुनर्योग सम्बन्धी सूचना।
                            </li>
                            <li class="mr-5 ">
                                माघ १ गते देखि २०७९ चैत मसान्त सम्म
                            </li>
                        </ul>
                    </marquee>
                </div>
            </div>

        </section>
        <section class="notice mt-1">
            <div class="row">
                <div class="col-md-8">
                    <div class="table-1">
                        <h2 class="heading text-white px-2 text-center">नागरिक वडापत्र</h2>
                        <table class="table bg-red table-bordered border-danger mb-0">
                            <thead>
                                <tr>
                                    <th width="5%">क्र.सं.</th>

                                    <th width="10%">सेवा</th>
                                    <th width="55%">आवश्यक कागजातहरु</th>
                                    <th width="15%">सेवा शुल्क</th>
                                    <th width="15%">लाग्ने समय</th>

                                </tr>
                            </thead>
                        </table>
                        <div id="scroll">
                            <table class="table table-success table-bordered">
                                <tbody class="align-top">
                                    <tr>
                                        <th class="text-start" width="6%">१</th>
                                        <td class="text-start" width="10%">पूर्वाधार विकास सेवा</td>
                                        <td class="text-start" width="55%">
                                            १.व्यक्ति वा संस्थाको व्यहोरा खुलेको निवेदन<br />
                                            २. सम्बन्धित वडा कार्यालयको सिफारिस पत्र<br />
                                            ३. पूर्वाधार विकास गर्नुपर्ने स्थानको अवस्था खुलेको तस्वीर
                                        </td>
                                        <td class="text-start" width="15%">निःशुल्क</td>
                                        <td class="text-start" width="15%">प्रकृया शुरु सोहीदिन</td>
                                    </tr>
                                    <tr>
                                        <th class="text-start" width="6%">२</th>
                                        <td class="text-start" width="10%">घ वर्गको निर्माण इजाजत दिने</td>
                                        <td class="text-start" width="55%">
                                            १. व्यहोरा खुलेको निवेदन<br />
                                            २. निर्माण इजाजत मापदण्डमा तोकिए बमोजिमको यन्त्र उपकरणहरुको स्वामित्व खुलेको
                                            कागजात<br />
                                            ३. निर्माण इजाजतका लागि तोकिए बमोजिमको जनशक्ति विवरण<br />
                                            ४.जनशक्तिको व्यक्तिगत विवरण
                                        </td>
                                        <td class="text-start" width="15%">नयमानुसार लाग्ने दस्तुर रु.१०,०००।–</td>
                                        <td class="text-start" width="15%">कागजात पेश भएको १५ दिनभित्र</td>
                                    </tr>
                                    <tr>
                                        <th class="text-start" width="6%">३</th>
                                        <td class="text-start" width="10%">New विकास सेवा</td>
                                        <td class="text-start" width="55%">
                                            १.व्यक्ति वा संस्थाको व्यहोरा खुलेको निवेदन<br />
                                            २. सम्बन्धित वडा कार्यालयको सिफारिस पत्र<br />
                                            ३. पूर्वाधार विकास गर्नुपर्ने स्थानको अवस्था खुलेको तस्वीर
                                        </td>
                                        <td class="text-start" width="15%">निःशुल्क</td>
                                        <td class="text-start" width="15%">प्रकृया शुरु सोहीदिन</td>
                                    </tr>
                                    <tr>
                                        <th class="text-start" width="6%">४</th>
                                        <td class="text-start" width="10%">आगालागीको सिफारिस</td>
                                        <td class="text-start" width="55%">
                                            १. व्यहोरा खुलेको निवेदन<br />
                                            २. सम्बन्धित वडा कार्यालयको सिफारिस पत्र<br />
                                            ३. नेपाल प्रहरीबाट चारकिल्ला र क्षतिको विवरण खुलेको घटनास्थल मुचुल्का<br />
                                            ४. जग्गा धनी प्रमाण पुर्जाको प्रतिलिपि<br />
                                            ५. चालु आर्थिक वर्षसम्मको तिर्नु बुझाउनु पर्ने सबै कर तिरेको प्रमाण<br />
                                            ६. सेवाग्राही संस्था भएमा व्यवसाय दर्ता र करचुक्ताको प्रमाणपत्रको प्रतिलिपि
                                        </td>
                                        <td class="text-start" width="15%">निःशुल्क</td>
                                        <td class="text-start" width="15%">कागजात पुरा भएको २४ घण्टाभित्र</td>
                                    </tr>
                                    <tr>
                                        <th class="text-start" width="6%">५</th>
                                        <td class="text-start" width="10%">FireInspection Correction (No Objection
                                            LetterNOC)</td>
                                        <td class="text-start" width="55%">
                                            १. व्यहोरा खुलेको निवेदन<br />
                                            २.सेवाग्राही व्यक्ति भए निजको नागरिकता प्रमाण पत्रकोप्रतिलिपि<br />
                                            ३. घरको नक्सा पास प्रमाणपत्रको प्रतिलिपि<br />
                                            ४.जग्गा धनी प्रमाण पुर्जाको प्रतिलिपि<br />
                                            ५. चालु आर्थिक वर्षसम्मको तिर्नु बुझाउनु पर्ने सबै कर तिरेको प्रमाण<br />
                                            ६.सेवाग्राही संस्था भएमा व्यवसाय दर्ता प्रमाणपत्र र करचुक्ताप्रमाणपत्रको
                                            प्रतिलिपि<br />
                                            ७. भवनमा रहेको अग्नी निवारण तथा अन्य प्रणालीको विवरणको सूचि
                                        </td>
                                        <td class="text-start" width="15%">रु.१५०००</td>
                                        <td class="text-start" width="15%">नवेदन पेश हुन आएको ७ दिनभित्र</td>
                                    </tr>
                                    <tr>
                                        <th class="text-start" width="6%">६</th>
                                        <td class="text-start" width="10%">Health Campaign</td>
                                        <td class="text-start" width="55%">
                                            Previous checkup reports
                                        </td>
                                        <td class="text-start" width="15%">500</td>
                                        <td class="text-start" width="15%">5 days</td>
                                    </tr>
                                    <tr>
                                        <th class="text-start" width="6%">७</th>
                                        <td class="text-start" width="10%">होर्डिङ्ग बोर्ड स्वीकृति</td>
                                        <td class="text-start" width="55%">
                                            १. व्यहोरा खुलेको निवेदन<br />
                                            २. निवेदक संघ संस्था भए सोको दर्ता प्रमाणपत्र, प्रबन्धपत्र नियमावली, कर
                                            दर्ता प्रमाणपत्र, कर चुक्ता प्रमाणपत्र<br />
                                            ३. होर्डिङ्ग बोर्ड राख्ने स्थान बहालमा लिने भए बहाल सम्झौताको
                                            प्रतिलिपि<br />
                                            ४. होर्डिङ्ग बोर्ड राखिने प्रस्तावित स्थान देखिने तस्विरहरु
                                        </td>
                                        <td class="text-start" width="15%">प्रति स्वायर फिट रु.१,०००</td>
                                        <td class="text-start" width="15%">बढीमा १५ दिन भित्र</td>
                                    </tr>
                                    <tr>
                                        <th class="text-start" width="6%">८</th>
                                        <td class="text-start" width="10%">सम्पत्ति कर छुट (सामाजिक संघ संस्थालाई
                                            मात्र)</td>
                                        <td class="text-start" width="55%">
                                            १. सम्पत्ति कर छुट माग गर्ने संस्थाको व्यहोरा खुलेको निवेदन<br />
                                            २. सम्बन्धित वडा कार्यालयको सिफारिसपत्र<br />
                                            ३. निवेदक संस्थाको संचालक समितिको निर्णय<br />
                                            ४. निवेदक संस्थाको सम्पत्ति व्यावसायिक कार्यमा प्रयोग नगरिएको प्रमाणि हुने
                                            कागजात<br />
                                            ५. कर चुक्ता÷छुट प्रमाणपत्र
                                        </td>
                                        <td class="text-start" width="15%">निःशुल्क</td>
                                        <td class="text-start" width="15%">९० दिन भित्र</td>
                                    </tr>
                                    <tr>
                                        <th class="text-start" width="6%">९</th>
                                        <td class="text-start" width="10%">सहकारी संघ तथा संस्था दर्ता गन</td>
                                        <td class="text-start" width="55%">
                                            १. संस्थाको हकमा कम्तिमा ३० जना नेपाली नागरिकहरुले पहिलो र दोस्रो गरी दुईवटा
                                            प्रारम्भिक भेला गरी सो को माइन्युट,<br />
                                            २. भेलाबाट स्वीकृत विधान वा विनियम,<br />
                                            ३. शेयर सदस्यहरुको फोटो र हस्ताक्षर सहितको विवरण,<br />
                                            ४. तदर्थ समितिको फोटो र हस्ताक्षर सहितको विवरण,<br />
                                            ५. निवेदकहरुको नागरिकता प्रमाणपत्रको प्रमाणित प्रतिलिपि,<br />
                                            ६. बसोवास तथा आवद्धता खुल्ने प्रमाणित कागजातहरु,<br />
                                            ७. सहकारी संस्था कार्यान्वयन कार्ययोजना,<br />
                                            ८. सहकारी तालिम लिएको प्रमाणपत्र,<br />
                                            ९. संभाव्यता अध्ययन प्रतिवेदन
                                        </td>
                                        <td class="text-start" width="15%">रु. १०।– को टिकट</td>
                                        <td class="text-start" width="15%">आवेदन पेश गरेको मितिले १५ दिनभित्र र
                                            अन्य थप संशोधन आवश्यक भएमा सो को लागि लाग्न समय</td>
                                    </tr>
                                    <tr>
                                        <th class="text-start" width="6%">१०</th>
                                        <td class="text-start" width="10%">सहकारी संघ\संस्थाको विधान वा विनियम
                                            संशोधन</td>
                                        <td class="text-start" width="55%">
                                            पछिल्लो साधारण सभामा कूल सदस्य संख्याको कम्तिमा ५१ प्रतिशत उपस्थित भई सो को
                                            कम्तिमा २ तिहाई बहुमतले सहकारी ऐन, नियम र सिद्धान्त एवं मापदण्ड अनुकूल हुने
                                            गरीे विनियम संशोधनको निर्णय गरी निर्णय प्रतिलिपि र तीन महले फारामको ढाँचामा
                                            संशोधित विनियम २ प्रति
                                        </td>
                                        <td class="text-start" width="15%">निःशुल्क</td>
                                        <td class="text-start" width="15%">विभागबाटै हुनेमा १५ दिन र कार्यपालिकाबाट
                                            स्वीकृति लिनुपर्ने भएमा सो को लागि लाग्ने समय</td>
                                    </tr>
                                    <tr>
                                        <th class="text-start" width="6%">११</th>
                                        <td class="text-start" width="10%">सहकारी संघ\संस्थाले नियमानुसार पाउने छुट
                                            सुविधाहरुको सिफारिश</td>
                                        <td class="text-start" width="55%">
                                            १. सम्बन्धित संघ÷संस्थाको व्यहोरा खुलेको पत्र<br />
                                            २. साधारण सभा तथा सञ्चालक समितिको निर्णयको प्रमाणित प्रतिलिपि<br />
                                            ३. घर जग्गा खरिदमा रजिष्ट्रेशन दस्तुर छुटको सिफारिश माग गर्दा मापदण्ड अनुसार
                                            खरिदका लागि आवश्यक स्रोतको विश्लेषण गरिएको कागजात
                                        </td>
                                        <td class="text-start" width="15%">निःशुल्क</td>
                                        <td class="text-start" width="15%">विभागबाटै हुनेमा १५ दिन र कार्यपालिकाबाट
                                            स्वीकृति लिनुपर्ने भएमा सो को लागि लाग्ने समय</td>
                                    </tr>
                                    <tr>
                                        <th class="text-start" width="6%">१२</th>
                                        <td class="text-start" width="10%">सहकारी संस्था एकीकरण र विभाजन</td>
                                        <td class="text-start" width="55%">
                                            १. सम्बन्धित संघ÷संस्थाको व्यहोरा खुलेको पत्र<br />
                                            २. दुई वा दुई भन्दा बढी संस्थाहरु आपसमा एकीकरण गर्न वा एक संस्थालाई दुई वा
                                            दुई भन्दा बढी संस्थामा विभाजन गर्न साधारण सभाको दुई तिहाई बहुमतबाट पारित
                                            निर्णय<br />
                                            ३. तोकिएका अन्य कागजातहरु
                                        </td>
                                        <td class="text-start" width="15%">निःशुल्क</td>
                                        <td class="text-start" width="15%">बढीमा ३५ दिन</td>
                                    </tr>
                                    <tr>
                                        <th class="text-start" width="6%">१३</th>
                                        <td class="text-start" width="10%">सहकारी संघ\संस्थाहरु सँग सम्वन्धित
                                            गुनासो\उजुरी सुनुवाई एवं समस्या समाधान गन</td>
                                        <td class="text-start" width="55%">
                                            १. निवेदकको व्यहोरा खुलेको निवेदन<br />
                                            २. आवश्यक प्रमाण कागजात<br />
                                            ३. निवेदकको नागरिकता प्रमाणपत्रको प्रतिलिपि
                                        </td>
                                        <td class="text-start" width="15%">निःशुल्क</td>
                                        <td class="text-start" width="15%">बढीमा १५ दिन</td>
                                    </tr>
                                    <tr>
                                        <th class="text-start" width="6%">१४</th>
                                        <td class="text-start" width="10%">सहकारी संघ संस्थाको तालीम \गोष्ठी \
                                            अन्तरक्रिया कार्यक्रम संचालन गन</td>
                                        <td class="text-start" width="55%">
                                            १.सम्बन्धित संघ \संस्थाको व्यहोरा खुलेको निवेदन पत्र
                                        </td>
                                        <td class="text-start" width="15%">निःशुल्क</td>
                                        <td class="text-start" width="15%">आवश्यकता अनुसार</td>
                                    </tr>
                                    <tr>
                                        <th class="text-start" width="6%">१५</th>
                                        <td class="text-start" width="10%">सहकारी संघ\संस्थाको अनुगमन, निरीक्षण
                                        </td>
                                        <td class="text-start" width="55%">
                                            १. सदस्यको व्यहोरा खुलेको निवेदन वा उजुरी
                                        </td>
                                        <td class="text-start" width="15%">निःशुल्क</td>
                                        <td class="text-start" width="15%">बढीमा १५ दिन</td>
                                    </tr>
                                    <tr>
                                        <th class="text-start" width="6%">१६</th>
                                        <td class="text-start" width="10%">शैक्षिक सूचना उपलब्ध गराउने कार्य</td>
                                        <td class="text-start" width="55%">
                                            IEMIS Excel Sheet,, विद्यालयको अद्यावधिक प्रोफाइल नलाग्ने
                                        </td>
                                        <td class="text-start" width="15%">निःशुल्क</td>
                                        <td class="text-start" width="15%">कार्यालय समयमा</td>
                                    </tr>
                                    <tr>
                                        <th class="text-start" width="6%">१७</th>
                                        <td class="text-start" width="10%">स ंस्थागत विद्यालय, विद्यालय व्यवस्थापन
                                            समिति अध्यक्ष मना ेनयन</td>
                                        <td class="text-start" width="55%">
                                            १. विद्यालयको निवेदन पत्र,<br />
                                            २. विद्यालय व्यवस्थापन समितिको बैठकको निर्णयको प्रतिलिपि, संस्थागत
                                            विद्यालय,<br />
                                            ३. व्यवस्थापन समितिले सिफारिस गरेको व्यक्तिको व्यक्तिगत विवरण (Bio
                                            Data)<br />
                                            ४. विद्यालय व्यवस्थापन समितिले सिफारिस गरेको व्यक्तिको शैक्षिक योग्यताको
                                            प्रमाणत्रको प्रतिलिपि,<br />
                                            ५.चालु आर्थिक वर्षसम्मको तिर्नु बुझाउनु पर्ने सबै
                                        </td>
                                        <td class="text-start" width="15%">रु.१,०००/-</td>
                                        <td class="text-start" width="15%">निर्णय भएको मितिले १ दिन भित्र</td>
                                    </tr>
                                    <tr>
                                        <th class="text-start" width="6%">१८</th>
                                        <td class="text-start" width="10%">संस्थागत विद्यालयको बैंक खाता खोल्ने तथा
                                            खाता मुद्दती नवीकरण</td>
                                        <td class="text-start" width="55%">
                                            १. विद्यालयको निवेदन पत्र,<br />
                                            २. विद्यालय व्यवस्थापन समितिको बैठकको निर्णयको प्रमाणित प्रतिलिपि,<br />
                                            ३. तोकिएको बैंकमा रकम जम्मा गरेको निस्सा <br />
                                            ४.चालु आर्थिक वर्षसम्मको तिर्नु बुझाउनु पर्ने सबै कर तिरेको प्रमाण
                                        </td>
                                        <td class="text-start" width="15%">रु.१,०००/-</td>
                                        <td class="text-start" width="15%">सोही दिन</td>
                                    </tr>
                                    <tr>
                                        <th class="text-start" width="6%">१९</th>
                                        <td class="text-start" width="10%">संस्थागत विद्यालयको नाम, स्थान तथा
                                            स्वामित्व परिवर्तन</td>
                                        <td class="text-start" width="55%">
                                            १. विद्यालय व्यवस्थापन समितिको बैठकको निर्णयको प्रमाणित प्रतिलिपि<br />
                                            २. वडा कार्यालयको सिफारिस ( ठाउं सारीको हकमा आउने र जाने दुबै वडाको
                                            सिफारिस)<br />
                                            ३. विद्यालयको शुरु अनुमति पत्र<br />
                                            ४. कम्पनी रजिष्टार कार्यालयको पत्र<br />
                                            ५. शेयरधनी दर्ता किताबको प्रतिलिपि<br />
                                            ६. चालु आर्थिक वर्षसम्मको तिर्नु बुझाउनु पर्ने सबै कर तिरेको प्रमाण<br />
                                            ७. लेखा परीक्षण प्रतिवेदन<br />
                                            ८. विद्यालयको ( प्रवन्ध पत्र) नियमावली<br />
                                            ९. विद्यालयको कर्मचारीको सेवा शर्त सम्बन्धी विनियमावली<br />
                                            १०. घर वहाल / लिज सम्झौता भए कम्तिमा ५ वर्षको सम्झौता पत्र<br />
                                            ११. विद्यालय निरीक्षकको स्थलगत प्रतिवेदन<br />
                                            १२. IEMIS Update गरेको निस्सा
                                        </td>
                                        <td class="text-start" width="15%">संस्थागत विद्यालय नाम परिवर्त न (
                                            आधारभुत) रु.३००००\- संस्थागत दिनभित्र विद्यालय नाम परिवर्त न माध्यमिक)
                                            रु.५०,०००\– संस्थागत विद्यालय स्थान परिवर्त न ( आधारभूत) रु.२०,००० \–
                                            संस्थागत विद्यालय स्थान परिवर्त न ( माध्यमिक) रु.३०,०००\– संस्थागत विद्यालय
                                            स्वामित्व परिवर्त न ( माध्यमिक) रु.३०,०००\- संस्थागत विद्यालय स्वामित्व
                                            परिवर्त न ( आधारभूत) रु.२०,०००</td>
                                        <td class="text-start" width="15%">शिक्षा समिति बाट निर्णय भएको मितिले ३
                                            दिनभित्र</td>
                                    </tr>
                                    <tr>
                                        <th class="text-start" width="6%">२०</th>
                                        <td class="text-start" width="10%">संस्थागत विद्यालय प्रमाणीकरण (
                                            verification) कक्षा १० र १२ बाहेक (visa सफारिसका लागि)</td>
                                        <td class="text-start" width="55%">
                                            १. विद्यार्थीको चारित्रिक प्रमाण पत्र<br />
                                            २. विद्यार्थीको लब्धाङ्क पत्र (Marksheet)<br />
                                            ३. विद्यालयको IEMIS Update भएको हुनुपर्ने<br />
                                            ४. विद्यालयको निवेदन
                                        </td>
                                        <td class="text-start" width="15%">रु.५००।</td>
                                        <td class="text-start" width="15%">१ घण्टा</td>
                                    </tr>
                                    <tr>
                                        <th class="text-start" width="6%">२१</th>
                                        <td class="text-start" width="10%">संस्थागत विद्यालयको लेखा परीक्षक
                                            नियुक्ति</td>
                                        <td class="text-start" width="55%">
                                            १. विद्यालय व्यवस्थापन समितिको बैठकको निर्णयको प्रतिलिपि,<br />
                                            २. विद्यालयले सिफारिस गरेको लेखापरीक्षकका प्रमाणपत्रहरु<br />
                                            3. चालु आर्थिक वर्षसम्मको तिर्नु बुझाउनु पर्ने सबै कर तिरेको प्रमाण<br />
                                            ४. शैक्षिक गुठीको गुठीको विधान वा कम्पनीको प्रबन्धपत्र तथा नियमावलीको
                                            प्रतिलिपि,
                                        </td>
                                        <td class="text-start" width="15%">रु.५००।</td>
                                        <td class="text-start" width="15%">१ घण्टा</td>
                                    </tr>
                                    <tr>
                                        <th class="text-start" width="6%">२२</th>
                                        <td class="text-start" width="10%">पूर्व प्राथमिक विद्यालय अनुमति / अभिले
                                            खीकरण</td>
                                        <td class="text-start" width="55%">
                                            १. जग्गा वा भवन भाडामा लिएको भए कम्तिमा ५ वर्ष सम्मको लागि घर वा जग्गाधनीसंग
                                            बहालमा लिने/दिने सम्बन्धमा | भएको कबुलियतनामा पत्रको प्रमाणित प्रतिलिपि,
                                            आफ्नो घर भए प्रतिलिपि, जग्गाको लालपुर्जाको<br />
                                            २. सम्बन्धित वडा कार्यालयको सक्कलै सहमति पत्र (नयां अनुमति लिन चाहनेको
                                            हकमा)<br />
                                            ३. संस्थाको नाम, ठेगाना र सम्पर्क नं., इमेल ठेगाना,<br />
                                            ४. संस्था दर्ताको प्रमाणपत्र, विद्यार्थीबाट उठाउने गरेको मासिक शुल्क
                                            (अभिलेखीकरण गर्न चाहनेको हकमा)<br />
                                            ५. विद्यालयको शैक्षिक नक्सा,<br />
                                            ६. विद्यालय सञ्चालनमा लाग्ने खर्च व्यहोर्ने स्थायी स्रोत खुलेको विद्यालयको
                                            सक्कलै पत्र र विद्यालयले विद्यार्थीसाग लिने शुल्क शुल्क प्रस्ताव
                                            विवरण,<br />
                                            ७. पाठ्यक्रम कार्यान्वयन तथा विषय छनौट निर्देशिका २०५५ तथा परिमार्जित २०६७
                                            बमोजिम विषय छनौट हुनुपर्ने<br />
                                            ८. शिक्षक नियूक्ति पत्र र नागरिकता, शैक्षिक योग्यताका प्रमाणपत्र, तथा
                                            अध्यापन अनुमति पत्रका प्रतिलिपिहरु ,<br />
                                            ९. विद्यालयमा कार्यरत शिक्षक, कर्मचारीको सेवा शर्त सम्बन्धी विनियमावलीको
                                            प्रतिलिपि र संस्थापकको नागरिकता र शैक्षिक योग्यताको प्रमाणपत्रको प्रतिलिपि
                                            तथा Biodata<br />
                                            १०. आयकर दर्ता (स्थायी लेखा नं) कर चूक्ता | प्रमाणपत्रको प्रतिलिपि र आ.व.
                                            २०७८ / ०७९ को लेखापरीक्षण प्रतिवेदनको प्रतिलिपि ,<br />
                                            ११. काठमाडौं महानगरपालिका विद्यालय शिक्षा | व्यवस्थापन नियमावली, २०७४ को
                                            अनुसूची २ एवं विद्यमान ऐन, नियम तथा कानुन बमोजिम पूर्वाधार पुगेको देखिने
                                            कागजातहरु,<br />
                                            १२. सम्बन्धित निरीक्षण क्षेत्रका विद्यालय | निरीक्षकको निरीक्षण प्रतिवेदन |
                                        </td>
                                        <td class="text-start" width="15%">नेपाल बैंक लिमिटेड, राष्ट्रिय वाणिज्य
                                            बैंक लिमिटेड तथा कृषि विकास बैंक लिमिटेडमध् ये कुनै एक बैंकमा सुरक्षण धरौटी
                                            बापत रु १,५०,००० 1- रकम | विद्यालयको नाममा जम्मा गर्नुपर्ने 1 साथै अभिलेखीकर
                                            णका लागि शुल्क नलाग्ने ।</td>
                                        <td class="text-start" width="15%">सम्बनि धत क्षेत्रको | विद्याल य निरीक्ष
                                            कको अनुगम न प्रतिवेद न प्राप्त भएको २ दिनभित्र</td>
                                    </tr>
                                    <tr>
                                        <th class="text-start" width="6%">२३</th>
                                        <td class="text-start" width="10%">संस्थागत विद्यालय कक्षा थप / कक्षा ११/१२
                                            मा विषय थप अनुमति</td>
                                        <td class="text-start" width="55%">
                                            १. शैक्षिक गुठीको विधान वा विद्यालय कक्षा प्रबन्धपत्र तथा नियमावलीको
                                            प्रतिलिपि, <br />
                                            २. जग्गा वा भवन भाडामा लिएको भए कम्तिमा छ वर्ष सम्मको लागि घर वा जग्गाधनीसंग
                                            बहालमा बहालमा लिने/दिने सम्बन्धमा भएको कवूलियतनामा पत्रको प्रमाणित
                                            प्रतिलिपि, आफ्नो घर भए प्रतिलिपि, जग्गाको लालपूर्जाको<br />
                                            ३. सम्बन्धित वडा कार्यालयले जारी गरेको सहमति पत्रको सक्कल प्रति<br />
                                            ४. संस्थाको नाम, ठेगाना, सम्पर्क नं. र इमेल ठेगाना,<br />
                                            ५. विद्यार्थीबाट उठाउने गरेको मासिक शुल्कको विवरण<br />
                                            ६. विद्यालयको शैक्षिक नक्सा<br />
                                            ७. विद्यालय सञ्चालनमा लाग्ने खर्च व्यहोर्ने स्थायी स्रोत खुलेको विद्यालयको
                                            सक्कल पत्र र विद्यार्थीसंग लिने शुल्क प्रस्ताव विद्यालयले विद्यार्थीसंग लिने
                                            विवरण,<br />
                                            ८. पाठ्यक्रम कार्यान्वयन तथा विषय छनौट निर्देशिका २०५५ (परिमार्जित
                                            समेत)<br />
                                            ९. शिक्षक नियुक्ति पत्र र निजहरुको नागरिकता, शैक्षिक योग्यताको प्रमाणपत्र
                                            तथा अध्यापन अनुमतिपत्रको प्रतिलिपि<br />
                                            १०. विद्यालयमा कार्यरत शिक्षक, कर्मचारीको | सेवा शर्त सम्बन्धी विनियमावलीको
                                            प्रतिलिपि र संस्थापकको नागरिकता र शैक्षिक योग्यताको प्रमाणपत्रको प्रतिलिपि
                                            तथा Biodata<br />
                                            11. चालु आर्थिक वर्षसम्मको तिर्नु बुझाउनु पर्ने सबै कर तिरेको प्रमाण<br />
                                            १२. पछिल्लो आर्थिक वर्षको वर्षको लेखापरीक्षण प्रतिवेदनको प्रतिलिपि<br />
                                            १३. आयकर दर्ता (स्थायी लेखा नं)<br />
                                            १४. काठमाडौं महानगरपालिका विद्यालय शिक्षा व्यवस्थापन नियमावली, २०७४ को
                                            अनूसूची २ एवं कानुन बमोजिम पुर्वाधार पगेको देखिने कागजातहरु,<br />
                                            १५. सम्बन्धित निरीक्षण क्षेत्रका विद्यालय निरीक्षकको निरीक्षण प्रतिवेदन |
                                        </td>
                                        <td class="text-start" width="15%">आधारभूत तहको हकमा रु.५,०००/- माध्यामिक
                                            तहको हकमा रु.१०,०००/- विषय थपको हकमा रु.१०,०००/</td>
                                        <td class="text-start" width="15%">शिक्षा समिति बाट निर्णय भएको मितिले ३
                                            दिनभित्र</td>
                                    </tr>
                                    <tr>
                                        <th class="text-start" width="6%">२४</th>
                                        <td class="text-start" width="10%">IEMIS Excel File Upload</td>
                                        <td class="text-start" width="55%">
                                            १. विद्यालयको नाम अग्रेजीमा<br />
                                            २. विद्यालय रहेको स्थानीय तहको नाम, ठेगाना र वडा नं<br />
                                            ३. सम्पर्क व्यक्तिको नाम, सम्पर्क नं र इमेल ठेगाना
                                        </td>
                                        <td class="text-start" width="15%">निःशुल्क</td>
                                        <td class="text-start" width="15%">सेवा प्रदान गर्ने केन्द्रबा ट प्राप्त
                                            हुनासा थ</td>
                                    </tr>
                                    <tr>
                                        <th class="text-start" width="6%">२५</th>
                                        <td class="text-start" width="10%">कक्षा ११/१२ मा संस्थागत विद्यालयमा
                                            Scholarship मा अध्ययन गरेको विषय प्रमाणीकरण</td>
                                        <td class="text-start" width="55%">
                                            १. सम्बन्धित विद्यालयको निवेदन<br />
                                            २. विद्यालयको अद्यावधिक IEMIS<br />
                                            ३. विद्यार्थीले छात्रवृत्तिमा अध्ययन गरेको खुल्ने सम्बन्धित क्षेत्रको
                                            विद्यालय निरीक्षक सहितको | माइन्यूट एवं विद्यार्थीहरुको नामावलीको प्रमाणित
                                            प्रतिलिपि
                                        </td>
                                        <td class="text-start" width="15%">निःशुल्क</td>
                                        <td class="text-start" width="15%">१ घण्टा</td>
                                    </tr>
                                    <tr>
                                        <th class="text-start" width="6%">२६</th>
                                        <td class="text-start" width="10%">नेपाल सरकारबाट सशर्त अनुदान निकासा</td>
                                        <td class="text-start" width="55%">
                                            १. विद्यालयले IEMIS मा अद्यावधिक गरेको विवरण<br />
                                            २. गत आर्थिक वर्षको निकासाको लेखापरीक्षण प्रतिवेदन<br />
                                            ३. छात्रवृत्तिको हकमा हकमा विद्याथीहरुले बझेको भर्पाइको प्रतिलिपि रकम
                                        </td>
                                        <td class="text-start" width="15%">नलग्ने</td>
                                        <td class="text-start" width="15%">तोकिए को चौमाि सक</td>
                                    </tr>
                                    <tr>
                                        <th class="text-start" width="6%">२७</th>
                                        <td class="text-start" width="10%">ग्रेडसिट सच्याउने</td>
                                        <td class="text-start" width="55%">
                                            १. खुलेको निवेदन <br />
                                            २. विद्यार्थीको जन्मदर्ताको प्रमाणित प्रतिलिपि <br />
                                            ३. विद्यालयको सिफारिस
                                        </td>
                                        <td class="text-start" width="15%">२००</td>
                                        <td class="text-start" width="15%">१ घण्टा</td>
                                    </tr>
                                    <tr>
                                        <th class="text-start" width="6%">२८</th>
                                        <td class="text-start" width="10%">प्रमाणपत्र प्रमाणीकरण</td>
                                        <td class="text-start" width="55%">
                                            १.व्यहोरा खुलेको निवेदन<br />
                                            २. सम्बन्धित प्रमाणपत्र
                                        </td>
                                        <td class="text-start" width="15%">५००</td>
                                        <td class="text-start" width="15%">१ घण्टा</td>
                                    </tr>
                                    <tr>
                                        <th class="text-start" width="6%">२९</th>
                                        <td class="text-start" width="10%">कक्षा को ८ बार्षिक परीक्षा सञ्चालन</td>
                                        <td class="text-start" width="55%">
                                            १. विद्यालयको अनलाइन फारम
                                        </td>
                                        <td class="text-start" width="15%">परीक्षा समितिले समिति निर्णय गरी तोके
                                            अनुसार</td>
                                        <td class="text-start" width="15%">परीक्षा समितिले समिति को निर्णय अनुसार
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="text-start" width="6%">३०</th>
                                        <td class="text-start" width="10%">कित्ताकाटसिफारिस</td>
                                        <td class="text-start" width="55%">
                                            १. ब्यहोरा खुलेको निवेदन<br />
                                            २. जग्गाधनी प्रमाणपूर्जाको प्रतिलिपि<br />
                                            ३. जग्गाको हालसालैको नापी नक्सा वा ट्रेस को प्रतिलिपि<br />
                                            ४. निवेदकको नागरिकता प्रमाणपत्रको प्रतिलिपि<br />
                                            ५. सम्वन्धित कार्यालयको पत्र<br />
                                            ६. चालु आर्थिक वर्ष सम्मको तिर्नु बुझाउनु पर्ने सबै कर तिरेको प्रमाण
                                        </td>
                                        <td class="text-start" width="15%">रु २०००</td>
                                        <td class="text-start" width="15%">सोहि दिन / सर्जमिन स्थलगत अध्ययनको हकमा
                                            ३ दिन</td>
                                    </tr>
                                    <tr>
                                        <th class="text-start" width="6%">३१</th>
                                        <td class="text-start" width="10%">स्वास्थ्य सम्बन्धी गतिविधिहरु बारे सूचना
                                            उपलब्ध गराउने</td>
                                        <td class="text-start" width="55%">
                                            १. निवेदकको व्यहोरा खुलेको निवेदन<br />
                                            २. निवेदकको परिचय खुल्ने कागजातको प्रतिलिपि
                                        </td>
                                        <td class="text-start" width="15%">निःशुल्क</td>
                                        <td class="text-start" width="15%">सामान्य भए सोही दिन र अन्यका हकमा ७ दिन
                                            भित्र</td>
                                    </tr>
                                    <tr>
                                        <th class="text-start" width="6%">३२</th>
                                        <td class="text-start" width="10%">परिवार नियोजन तथा सुरक्षित मातृत्व
                                            सम्बन्धी सूचना प्रदान</td>
                                        <td class="text-start" width="55%">
                                            १. निवेदकको व्यहोरा खुलेको निवेदन<br />
                                            २. निवेदकको परिचय खुल्ने कागजातको प्रतिलिपि
                                        </td>
                                        <td class="text-start" width="15%">निःशुल्क</td>
                                        <td class="text-start" width="15%">सोही दिन</td>
                                    </tr>
                                    <tr>
                                        <th class="text-start" width="6%">३३</th>
                                        <td class="text-start" width="10%">बाल स्वास्थ्य तथा पोषण सम्बन्धी सूचना
                                            प्रदान</td>
                                        <td class="text-start" width="55%">
                                            १. निवेदकको व्यहोरा खुलेको निवेदन<br />
                                            २. निवेदकको परिचय खुल्ने कागजातको प्रतिलिपि
                                        </td>
                                        <td class="text-start" width="15%">निःशुल्क</td>
                                        <td class="text-start" width="15%">सोही दिन</td>
                                    </tr>
                                    <tr>
                                        <th class="text-start" width="6%">३४</th>
                                        <td class="text-start" width="10%">विपन्न नागरिक औषधी उपचार सिफारिस</td>
                                        <td class="text-start" width="55%">
                                            १. विरामीको नेपाली नागरिकताको प्रमाणपत्रको प्रतिलिपि<br />
                                            २. निवेदकको नागरिकताको प्रमाणपत्रको प्रतिलिपि<br />
                                            ३. आर्थिक अवस्था खुलेको सम्बन्धित वडा कार्यालयको सक्कल सिफारिसपत्र<br />
                                            ४ सम्बन्धित अस्पतालबाट प्राप्त बिरामीको रोग खुलेको सक्कल सिफारिसपत्र<br />
                                            ५. सम्बन्धित अस्पताल/चिकित्सकवाट प्राप्त बिरामीको रोग खुलेको कागजातको
                                            प्रतिलिपि - <br />
                                            क) प्रेस्किप्सन <br />
                                            ख) भर्ना फाराम <br />
                                            ग) डिस्चार्ज भएकाको हकमा डिस्चार्ज कागजात <br />
                                            घ) रोग पत्ता लागेको कागजातको प्रतिलिपि<br />
                                            ६. पासपोर्ट साइजको फोटो २ वटा<br />
                                            ७. रु १० को टिकट
                                        </td>
                                        <td class="text-start" width="15%">निःशुल्क</td>
                                        <td class="text-start" width="15%">सिफारिस प्रत्येक हप्ता मंगलबार र
                                            शुक्रबार</td>
                                    </tr>
                                    <tr>
                                        <th class="text-start" width="6%">३५</th>
                                        <td class="text-start" width="10%">मृगौला प्रत्यारोपण गरेका डायलाईसिस
                                            गरिरहेका क्यान्सर रोगी र मेरुदण्ड पक्षघातका विरामीलाई औषधी उपचार वापत खर्च
                                            उपलब्ध गराउने</td>
                                        <td class="text-start" width="55%">
                                            १. तोकिएको ढाँचाको निवेदन,<br />
                                            २. बिरामीको नेपाली नागरिकताको प्रमाणपत्र प्रतिलिपी/नाबालकको हकमा जन्मदर्ता
                                            प्रमाणपत्र प्रतिलिपि,<br />
                                            ३. अन्यत्रबाट बसाईसराई गरी आएको बसाईसराई प्रमाणपत्रको प्रतिलिपि, <br />
                                            ४ चिकित्सकबाट प्रमाणित गरिएको कार्यविधि अनुसूची १ १ बमोजिमको फाराम,<br />
                                            ५. बिरामी उपचाररत अस्पतालको सम्बन्धि चिकित्सकबाट प्रमाणित गरिएका
                                            कागजातहरु<br />
                                            ६.मेरुदण्ड पक्षघात भएका व्यक्तिहरुका हक अपाङ्गता परिचयपत्रको (रातो वा निलो)
                                            प्रतिलिपि
                                        </td>
                                        <td class="text-start" width="15%">निःशुल्क</td>
                                        <td class="text-start" width="15%">चौमासिक रुपमा</td>
                                    </tr>
                                    <tr>
                                        <th class="text-start" width="6%">३६</th>
                                        <td class="text-start" width="10%">QR code प्रमाणीकरण</td>
                                        <td class="text-start" width="55%">
                                            १. अनलाइन फाराम भर्दा अपलोड गर्नुपर्ने कागजातहरु<br />
                                            • निवेदकको नागरिकताको प्रमाणपत्र वा राहदानी<br />
                                            • सक्कल खोप कार्ड<br />
                                            • पासपोर्ट साइजको फोटो २ वटा
                                        </td>
                                        <td class="text-start" width="15%">निःशुल्क</td>
                                        <td class="text-start" width="15%">३ दिन</td>
                                    </tr>
                                    <tr>
                                        <th class="text-start" width="6%">३७</th>
                                        <td class="text-start" width="10%">रक्तदातामा आधारित अनुदान उपलब्ध गराउने
                                        </td>
                                        <td class="text-start" width="55%">
                                            १ व्यहोरा खुलेको निवेदन<br />
                                            २. पूर्व स्वीकृति लिएको पत्र<br />
                                            ३) रक्तदान कार्यक्रम गर्ने संस्थाको दर्ता प्रमाणपत्र<br />
                                            ४ ) का.म.पा. सँगको सहकार्यमा उल्लेख भएको व्यानर<br />
                                            ५) रक्तदाताहरुको विवरण<br />
                                            ६) रगत भण्डारण गरे वापत नेपाल रेडक्रस सोसाईटीबाट प्रदान गरिने प्रसंशापत्र वा
                                            सिफारिसपत्र<br />
                                            ७) वडा कार्यालयको सिफारिसपत्र<br />
                                            ८) रक्तदान कार्यक्रममा हुने खर्चको विवरण<br />
                                            ९) अन्य संस्थाबाट कुनै आर्थिक सहयोग नलिएको प्रतिवद्धतापत्र<br />
                                            १०) कार्यक्रमको फोटोहरु
                                        </td>
                                        <td class="text-start" width="15%">निःशुल्क</td>
                                        <td class="text-start" width="15%">सोही दिन</td>
                                    </tr>
                                    <tr>
                                        <th class="text-start" width="6%">३८</th>
                                        <td class="text-start" width="10%">स्वास्थ्य संस्था दर्ता</td>
                                        <td class="text-start" width="55%">
                                            १. तोकिएको ढाँचाको निवेदन फारम<br />
                                            २. कम्पनी/संस्था दर्ता प्रमाणपत्रको प्रतिलिपि<br />
                                            ३. कम्पनी/संस्थाको विधान/प्रवन्धपत्र, नियमावलीको प्रतिलिपि<br />
                                            ४. स्थायी लेखा दर्ता प्रमाणपत्र (PAN) को प्रतिलिपि<br />
                                            ५. स्थापना गर्न लागिएको ठाउँमा स्वास्थ्य संस्था आवश्यक छ भन्ने सम्बन्धित
                                            वडाको सिफारिसपत्र<br />
                                            ६. स्वास्थ्य संस्थामा काम गर्ने जनशक्ति सम्बन्धी विवरण<br />
                                            (क) बायोडाटा<br />
                                            (ख)शैक्षिक योग्यता र कर्मचारीले लिएका तालिम प्रमाणपत्रको प्रतिलिपि<br />
                                            (ग)प्राविधिक कर्मचारीहरुको सम्बन्धित काउन्सिल दर्ता प्रमाणपत्रको
                                            प्रतिलिपि<br />
                                            (घ) नागरिकता प्रमाणपत्रको प्रतिलिपि<br />
                                            (ङ) जनशक्तिहरुको काम गर्ने समय (पार्टटाइम/फुलटाइम किटान गर्नु पर्नेछ)<br />
                                            (च) स्वास्थ्य संस्थामा काम गर्ने मञ्जुरीनामा/कबुलियतनामा<br />
                                            ७. स्वास्थ्योपचारमा प्रयोग हुने औजार तथा उपकरणको विवरण<br />
                                            ८. स्वास्थ्य संस्थाले प्रदान गर्ने सेवा शुल्कहरुको विवरण र गरीब तथा असहायलाई
                                            छुट दिने नीति<br />
                                            ९. भौतिक सामग्रीको विवरण<br />
                                            १०. अस्पतालको हकमा प्रारम्भिक वातावरणीय परीक्षण (IEE) वा वातावरणीय प्रभाव
                                            मूल्यांकन (EIA) स्वीकृतिपत्रको प्रतिलिपि<br />
                                            ११. अस्पतालको विस्तृत सर्भेक्षण सहितको प्रस्ताव<br />
                                            १२. अस्पतालको आर्थिक नियमावली<br />
                                            १३. स्वास्थ्य संस्थाबाट प्रदान हुने सेवाहरुको विवरण<br />
                                            १४. आफ्नै भए जग्गा/घरको स्वामित्वको प्रमाणपत्र<br />
                                            १५. घर/कोठा बहालमा लिई सञ्चालन गर्ने भए घर बहाल सम्झौतापत्र र प्रयोगमा
                                            ल्याइने भवन स्वास्थ्य संस्था सञ्चालन गर्न राष्ट्रिय भवन संहिता बमोजिम
                                            उपयुक्त छ भन्ने सम्बन्धी सिफारिसपत्र<br />
                                            १६. भवनको स्वीकृत नक्सा<br />
                                            १७.संस्थाको चल अचल सम्पत्ति विवरण तथा वित्तीय स्रोत<br />
                                            १८.संस्थाको कार्ययोजना<br />
                                            १९. बिरामी बडापत्रको नमूना<br />
                                            २०. सम्बन्धित निकायको भवन संहिता सम्बन्धी स्वीकृति पत्र<br />
                                            २१. रु. १० को हुलाक टिकट<br />
                                            २२. मूल्य अभिवृद्धि कर वा आयकरमा दर्ता भएको प्रमाणपत्र<br />
                                            २३. भवन निर्माण सम्पन्न प्रमाणपत्र<br />
                                            २४. अस्पतालजन्य, रासायनिक तथा घरेलु फोहरमैला व्यवस्थापन सम्बन्धी योजना<br />
                                            २५. व्यवसाय दर्ता प्रमाण पत्रको प्रतिलिपि
                                        </td>
                                        <td class="text-start" width="15%">१.अस्पताल तथा नसिङ्ग होमका हकमा प्रति
                                            शैया रु.४,०००।– २ .डायग्नोस्टिक सेन्टरका हकमा प्रति सेवा रु. १०,०००।–
                                            ३.पोलिक्लिनिक/क्लिनिकका हकमा प्रति सेवा रु १०,०००।– ४. आयुर्वेद
                                            अस्पताल/वैकल्पिक चिकित्साका हकमा प्रति शैया रु. ५,०००।– ५ आयुर्वेद क्लिनिक
                                            सेवाका हकमा प्रति सेवा रु.५,०००।</td>
                                        <td class="text-start" width="15%">अनुगमन समितिबाट प्रतिवेदन प्राप्त भएको
                                            मितिले ७ दिन भित्र</td>
                                    </tr>
                                    <tr>
                                        <th class="text-start" width="6%">३९</th>
                                        <td class="text-start" width="10%">स्वास्थ्य संस्था नविकरण</td>
                                        <td class="text-start" width="55%">
                                            १. तोकिएको ढाँचाको निवेदन फारम<br />
                                            २. कर चुक्ता प्रमाणपत्रको प्रतिलिपि<br />
                                            ३. गत आर्थिक वर्षको लेखापरीक्षण प्रतिवेदन
                                        </td>
                                        <td class="text-start" width="15%">१. अस्पताल तथा नसिङ्ग होमका हकमा प्रति
                                            शैया रु. ५००/- २ डायग्नोस्टिक सेन्टरका हकमा प्रति सेवा रु. १,०००/- ३.
                                            पोलिक्लिनिक / क्लिनिकका हकमा प्रति सेवा रु १,०००/- ४. आयुर्वेद अस्पताल /
                                            वैकल्पिक चिकित्साका हकमा प्रति शैया रु ५००/- ५ आयुर्वेद क्लिनिक सेवाका हकमा
                                            प्रति सेवा रु.५,००।</td>
                                        <td class="text-start" width="15%">अनुगमन समितिबाट प्रतिवेदन प्राप्त भएको
                                            मितिले ७ दिन भित्र</td>
                                    </tr>
                                    <tr>
                                        <th class="text-start" width="6%">४०</th>
                                        <td class="text-start" width="10%">स्वास्थ्य संस्था स्तरोन्नति</td>
                                        <td class="text-start" width="55%">
                                            १. तोकिएको ढाँचाको निवेदन फारम<br />
                                            २. स्वास्थ्य संस्था दर्ता प्रयोजनका लागि पेश गर्नुपर्ने भनी खुलाइएका
                                            कागजातहरु<br />
                                            ३. स्वास्थ्य संस्था स्तरोन्नति सम्बन्धी योजना र योजना कार्यान्वयनका लागि
                                            आवश्यक पर्ने साधन तथा सोत खुलेको विवरण
                                        </td>
                                        <td class="text-start" width="15%">१. अस्पताल तथा नर्सिङ्ग होम स्तरोन्नति
                                            गर्दा थप शैयाका लागि प्रति शैया रु.४,०००/- २ डायग्नोस्टिक सेन्टर स्तरोन्नति
                                            गर्दा थप सेवाका लागि प्रति सेवा रु १०,०००/- ३. पोलिक्लिनिक / क्लिनिकक
                                            स्तरोन्नति गर्दा थप सेवाका लागि प्रति सेवा रु १०,०००/- ४. आयुर्वेद अस्पताल
                                            वैकल्पिक चिकित्सा स्तरोन्नति गर्दा थप शैयाका लागि प्रति शैया रु. ५,०००/- ५
                                            आयुर्वेद क्लिनिक सेवा स्तरोन्नति गर्दा थप सेवाका लागि प्रति सेवा ५,०००/-
                                        </td>
                                        <td class="text-start" width="15%">अनुगमन समितिबाट प्रतिवेदन प्राप्त भएको
                                            मितिले ७ दिन भित्र</td>
                                    </tr>
                                    <tr>
                                        <th class="text-start" width="6%">४१</th>
                                        <td class="text-start" width="10%">संघ संस्था सूची दर्ता</td>
                                        <td class="text-start" width="55%">
                                            १. व्यहोरा खुलेको निवेदन<br />
                                            २. चालु आर्थिक वर्षसम्मको तिर्नु बुझाउनु पर्ने सबै कर तिरेको प्रमाण<br />
                                            ३. संघ संस्थादर्ता नविकरण प्रमाणपत्र<br />
                                            ४. कर दर्ता र कर चुक्ता प्रमाणपत्र
                                        </td>
                                        <td class="text-start" width="15%">नि:शुल्क</td>
                                        <td class="text-start" width="15%">सोही दिन</td>
                                    </tr>
                                    <tr>
                                        <th class="text-start" width="6%">४२</th>
                                        <td class="text-start" width="10%">बैंक ग्यारेण्टी फुकुवा पत्र</td>
                                        <td class="text-start" width="55%">
                                            १. व्यहोरा खुलेको निवेदन<br />
                                            २. बैंक ग्यारेन्टी पत्रको प्रतिलिपि
                                        </td>
                                        <td class="text-start" width="15%">निःशुल्क</td>
                                        <td class="text-start" width="15%">सोही दिन</td>
                                    </tr>
                                    <tr>
                                        <th class="text-start" width="6%">४३</th>
                                        <td class="text-start" width="10%">कार्य सम्पादन जमानत जम्मा गर्ने</td>
                                        <td class="text-start" width="55%">
                                            १. बैंक ग्यारेण्टी वा नगद जम्मा गरेको बैंक भौचर<br />
                                            २. प्रस्तावमा स्वीकार गरिएको कार्यतालिका<br />
                                            ३. व्यवसाय दर्ता प्रमाणपत्रको प्रतिलिपि
                                        </td>
                                        <td class="text-start" width="15%">निःशुल्क</td>
                                        <td class="text-start" width="15%">सोही दिन</td>
                                    </tr>
                                    <tr>
                                        <th class="text-start" width="6%">४४</th>
                                        <td class="text-start" width="10%">मागका आधारमा सूचना/जानकारी प्रवाह</td>
                                        <td class="text-start" width="55%">
                                            १. व्यहोरा तथा सूचनाको प्रयोजन खुलेको निवेदन <br />
                                            २. निवेदकको परिचय खुल्ने कागजातको प्रतिलिपि
                                        </td>
                                        <td class="text-start" width="15%">प्रचलित कानुनले तोकेकोमा सोही बमोजिमको
                                            दस्तुर र अन्यको हकमा निःशुल्क</td>
                                        <td class="text-start" width="15%">सोही दिन/अन्य निकायसँग माग गरी उपलब्ध
                                            गराउनु पर्ने भए बढिमा सात दिन</td>
                                    </tr>
                                    <tr>
                                        <th class="text-start" width="6%">४५</th>
                                        <td class="text-start" width="10%">दरभाउ पत्र तथा बोलपत्र पुनरावलोकन</td>
                                        <td class="text-start" width="55%">
                                            १. प्रमुख प्रशासकीय अधिकृतलाई सम्बोधन गरी विषय सँग सम्बन्धित व्यहोरा खुलेको
                                            निवेदन<br />
                                            २. आशयपत्र जारी भएको सूचनाको प्रतिलिपि
                                        </td>
                                        <td class="text-start" width="15%">निःशुल्क</td>
                                        <td class="text-start" width="15%">बढीमा ५ दिनभित्र</td>
                                    </tr>
                                    <tr>
                                        <th class="text-start" width="6%">४६</th>
                                        <td class="text-start" width="10%">नक्सापास विरुद्धको उजुरी</td>
                                        <td class="text-start" width="55%">
                                            १. व्यहोरा खुलेको तोकिएको ढाँचाको उजुरी निवेदन<br />
                                            २. विवादित जग्गाको नापी नक्सा<br />
                                            ३. उजुरी पुष्ट्याई गर्ने अन्य कागजातहरु
                                        </td>
                                        <td class="text-start" width="15%">रु. ५०/-</td>
                                        <td class="text-start" width="15%">सोही दिन</td>
                                    </tr>
                                    <tr>
                                        <th class="text-start" width="6%">४७</th>
                                        <td class="text-start" width="10%">गैर कानूनी निर्माण सम्बन्धी उजुरी</td>
                                        <td class="text-start" width="55%">
                                            १. तोकिए बमोजिमको ढाँचामा उजुरी निवेदन<br />
                                            २. विवादित जग्गाको नापी नक्सा<br />
                                            ३. जग्गाधनी प्रमाणपुर्जाको नक्कल<br />
                                            ४. उजुरीकर्ताको घर भए स्वीकृत नक्सापासको कागजात<br />
                                            ५. अन्य कागजातको प्रतिलिपि
                                        </td>
                                        <td class="text-start" width="15%">रु. ५०/-</td>
                                        <td class="text-start" width="15%">सोही दिन</td>
                                    </tr>
                                    <tr>
                                        <th class="text-start" width="6%">४८</th>
                                        <td class="text-start" width="10%">सार्वजनिक सम्पत्ति अतिक्रमण गरी हानी
                                            नोक्सानी गरेको भन्ने उजुरी</td>
                                        <td class="text-start" width="55%">
                                            १. तोकिए बमोजिमको ढाँचामा उजुरी निवेदन<br />
                                            २. जग्गाको नापी नक्सा<br />
                                            ३. सम्बन्धित वडा कार्यालयको पत्र
                                        </td>
                                        <td class="text-start" width="15%">रु. ५०/-</td>
                                        <td class="text-start" width="15%">सोही दिन</td>
                                    </tr>
                                    <tr>
                                        <th class="text-start" width="6%">४९</th>
                                        <td class="text-start" width="10%">सम्बन्ध विच्छेद सिफारिस सम्बन्धी
                                            फिरादपत्र</td>
                                        <td class="text-start" width="55%">
                                            १. तोकिए बमोजिमको ढाँचामा पेश गरिएको फिराद पत्र<br />
                                            २. नेपाली नागरिकता प्रमाणपत्रको प्रतिलिपी<br />
                                            ३. विवाह दर्ता प्रमाणपत्रको प्रतिलिपी<br />
                                            ४. विदेशी नागरिक भएमा राहदानीको प्रमाणित प्रतिलिपि
                                        </td>
                                        <td class="text-start" width="15%">.</td>
                                        <td class="text-start" width="15%">सोही दिन/अन्य निकाय संग माग गरी उपलब्ध
                                            गराउनु पर्ने भए अधिकतम सात दिन</td>
                                    </tr>
                                    <tr>
                                        <th class="text-start" width="6%">५०</th>
                                        <td class="text-start" width="10%">ध्वनी लगायतका प्रदुर्षण सम्बन्धी उजुरी
                                        </td>
                                        <td class="text-start" width="55%">
                                            १. व्यहोरा खुलेकोनिवेदन<br />
                                            २. स्थान खुल्ने व्यहोरा (बाटोको नाम घर नम्बर समेत)
                                        </td>
                                        <td class="text-start" width="15%">.</td>
                                        <td class="text-start" width="15%">.</td>
                                    </tr>
                                    <tr>
                                        <th class="text-start" width="6%">५१</th>
                                        <td class="text-start" width="10%">प्रतिलिपि प्रमाण कागजातहरु</td>
                                        <td class="text-start" width="55%">
                                            १. व्यहोरा खुलेको निवेदन<br />
                                            २. नागरिकता प्रमाणपत्रको प्रतिलिपि
                                        </td>
                                        <td class="text-start" width="15%">लाग्ने दस्तुर</td>
                                        <td class="text-start" width="15%">.</td>
                                    </tr>
                                    <tr>
                                        <th class="text-start" width="6%">५२</th>
                                        <td class="text-start" width="10%">भवन नक्सा नामसारी</td>
                                        <td class="text-start" width="55%">
                                            १. व्यहोरा खुलेकोनिवेदन<br />
                                            २. रजिष्टेसन पास कागज<br />
                                            ३. अंशवण्डाबाट आएको भए अंशवण्डाको कागज<br />
                                            ४. जग्गाधनी प्रमाणपुर्जाको प्रतिलिपि<br />
                                            ५. अन्य कुनै व्यहोराले हक हस्तान्तरण भई आएको भए सो को कानून बमोजिम पारित
                                            लिखित<br />
                                            ६. लिने दिनेको मञ्जुरीनामा
                                        </td>
                                        <td class="text-start" width="15%">.</td>
                                        <td class="text-start" width="15%">.</td>
                                    </tr>
                                    <tr>
                                        <th class="text-start" width="6%">५३</th>
                                        <td class="text-start" width="10%">घटना दर्ता तथा नाताप्रमाणित</td>
                                        <td class="text-start" width="55%">
                                            .
                                        </td>
                                        <td class="text-start" width="15%">लाग्ने दस्तुर</td>
                                        <td class="text-start" width="15%">.</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="row">
                        
                        <div class="">
                            <h2 class="jana text-center text-white px-2 mb-0">जिम्मेवार पदाधिकारी/कर्मचारी</h2>
                            <x-employee-section-component/>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <footer class="footer position-fixed footer-alt bg-soft-main">
        2023 - 2024 &copy; Design & Developed by <a href="#" class="text-white text-decoration-underline"></a>
    </footer>

    <script src="https://demoerp.palikaerp.com/assets/frontend/js/jquery.min.js"></script>
    <script src="https://demoerp.palikaerp.com/assets/frontend/js/bootstrap.min.js"></script>
    <script src="https://demoerp.palikaerp.com/assets/frontend/js/custom.min.js"></script>
    <script src="https://demoerp.palikaerp.com/assets/frontend/js/simplyScroll.js"></script>
    <script src="https://demoerp.palikaerp.com/assets/frontend/js/owl/owl.carousel.min.js"></script>
    <script src="http://nepalidatepicker.sajanmaharjan.com.np/nepali.datepicker/js/nepali.datepicker.v4.0.4.min.js"
        type="text/javascript"></script>
    <script src="https://demoerp.palikaerp.com/assets/backend/print/print.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            var owl = $('.owl-carousel');
            owl.owlCarousel({
                items: 1,
                loop: true,
                margin: 10,
                autoplay: true,
                autoplayTimeout: 3000,
                autoplayHoverPause: true
            });
        });
    </script>
    <script type="text/javascript">
        (function($) {
            $(function() {
                $("#scroll").simplyScroll({
                    customClass: 'vert',
                    orientation: 'vertical',
                    auto: true,
                    manualMode: 'loop',
                    frameRate: 20,
                    speed: 1
                });
            });
        })(jQuery);
    </script>

    <script src="/vendor/livewire/livewire.js?id=90730a3b0e7144480175" data-turbo-eval="false" data-turbolinks-eval="false">
    </script>


    <script src="https://demoerp.palikaerp.com/js/newRelic.min.js"></script>
    <script type="text/javascript">
        var phpdebugbar = new PhpDebugBar.DebugBar();
        phpdebugbar.addIndicator("php_version", new PhpDebugBar.DebugBar.Indicator({
            "icon": "code",
            "tooltip": "PHP Version"
        }), "right");
        phpdebugbar.addTab("messages", new PhpDebugBar.DebugBar.Tab({
            "icon": "list-alt",
            "title": "Messages",
            "widget": new PhpDebugBar.Widgets.MessagesWidget()
        }));
        phpdebugbar.addIndicator("time", new PhpDebugBar.DebugBar.Indicator({
            "icon": "clock-o",
            "tooltip": "Request Duration"
        }), "right");
        phpdebugbar.addTab("timeline", new PhpDebugBar.DebugBar.Tab({
            "icon": "tasks",
            "title": "Timeline",
            "widget": new PhpDebugBar.Widgets.TimelineWidget()
        }));
        phpdebugbar.addIndicator("memory", new PhpDebugBar.DebugBar.Indicator({
            "icon": "cogs",
            "tooltip": "Memory Usage"
        }), "right");
        phpdebugbar.addTab("exceptions", new PhpDebugBar.DebugBar.Tab({
            "icon": "bug",
            "title": "Exceptions",
            "widget": new PhpDebugBar.Widgets.ExceptionsWidget()
        }));
        phpdebugbar.addTab("views", new PhpDebugBar.DebugBar.Tab({
            "icon": "leaf",
            "title": "Views",
            "widget": new PhpDebugBar.Widgets.TemplatesWidget()
        }));
        phpdebugbar.addTab("route", new PhpDebugBar.DebugBar.Tab({
            "icon": "share",
            "title": "Route",
            "widget": new PhpDebugBar.Widgets.HtmlVariableListWidget()
        }));
        phpdebugbar.addIndicator("currentroute", new PhpDebugBar.DebugBar.Indicator({
            "icon": "share",
            "tooltip": "Route"
        }), "right");
        phpdebugbar.addTab("queries", new PhpDebugBar.DebugBar.Tab({
            "icon": "database",
            "title": "Queries",
            "widget": new PhpDebugBar.Widgets.LaravelSQLQueriesWidget()
        }));
        phpdebugbar.addTab("models", new PhpDebugBar.DebugBar.Tab({
            "icon": "cubes",
            "title": "Models",
            "widget": new PhpDebugBar.Widgets.HtmlVariableListWidget()
        }));
        phpdebugbar.addTab("livewire", new PhpDebugBar.DebugBar.Tab({
            "icon": "bolt",
            "title": "Livewire",
            "widget": new PhpDebugBar.Widgets.VariableListWidget()
        }));
        phpdebugbar.addTab("gate", new PhpDebugBar.DebugBar.Tab({
            "icon": "list-alt",
            "title": "Gate",
            "widget": new PhpDebugBar.Widgets.MessagesWidget()
        }));
        phpdebugbar.addTab("session", new PhpDebugBar.DebugBar.Tab({
            "icon": "archive",
            "title": "Session",
            "widget": new PhpDebugBar.Widgets.VariableListWidget()
        }));
        phpdebugbar.addTab("request", new PhpDebugBar.DebugBar.Tab({
            "icon": "tags",
            "title": "Request",
            "widget": new PhpDebugBar.Widgets.HtmlVariableListWidget()
        }));
        phpdebugbar.setDataMap({
            "php_version": ["php.version", ],
            "messages": ["messages.messages", []],
            "messages:badge": ["messages.count", null],
            "time": ["time.duration_str", '0ms'],
            "timeline": ["time", {}],
            "memory": ["memory.peak_usage_str", '0B'],
            "exceptions": ["exceptions.exceptions", []],
            "exceptions:badge": ["exceptions.count", null],
            "views": ["views", []],
            "views:badge": ["views.nb_templates", 0],
            "route": ["route", {}],
            "currentroute": ["route.uri", ],
            "queries": ["queries", []],
            "queries:badge": ["queries.nb_statements", 0],
            "models": ["models.data", {}],
            "models:badge": ["models.count", 0],
            "livewire": ["livewire.data", {}],
            "livewire:badge": ["livewire.count", 0],
            "gate": ["gate.messages", []],
            "gate:badge": ["gate.count", null],
            "session": ["session", {}],
            "request": ["request", {}]
        });
        phpdebugbar.restoreState();
        phpdebugbar.ajaxHandler = new PhpDebugBar.AjaxHandler(phpdebugbar, undefined, true);
        phpdebugbar.ajaxHandler.bindToFetch();
        phpdebugbar.ajaxHandler.bindToXHR();
        phpdebugbar.setOpenHandler(new PhpDebugBar.OpenHandler({
            "url": "https:\/\/demoerp.palikaerp.com\/_debugbar\/open"
        }));
        phpdebugbar.addDataSet({
            "__meta": {
                "id": "X6ca05b514f3ed474fb7fb237d3f280c4",
                "datetime": "2024-11-20 15:48:08",
                "utime": 1732096988.798653,
                "method": "GET",
                "uri": "\/",
                "ip": "103.235.197.229"
            },
            "php": {
                "version": "8.3.1",
                "interface": "fpm-fcgi"
            },
            "messages": {
                "count": 0,
                "messages": []
            },
            "time": {
                "start": 1732096988.542755,
                "end": 1732096988.798673,
                "duration": 0.255918025970459,
                "duration_str": "256ms",
                "measures": [{
                    "label": "Booting",
                    "start": 1732096988.542755,
                    "relative_start": 0,
                    "end": 1732096988.748799,
                    "relative_end": 1732096988.748799,
                    "duration": 0.20604419708251953,
                    "duration_str": "206ms",
                    "memory": 0,
                    "memory_str": "0B",
                    "params": [],
                    "collector": null
                }, {
                    "label": "Application",
                    "start": 1732096988.748911,
                    "relative_start": 0.20615601539611816,
                    "end": 1732096988.798675,
                    "relative_end": 2.1457672119140625e-6,
                    "duration": 0.049764156341552734,
                    "duration_str": "49.76ms",
                    "memory": 0,
                    "memory_str": "0B",
                    "params": [],
                    "collector": null
                }]
            },
            "memory": {
                "peak_usage": 5923800,
                "peak_usage_str": "6MB"
            },
            "exceptions": {
                "count": 0,
                "exceptions": []
            },
            "views": {
                "nb_templates": 13,
                "templates": [{
                    "name": "frontend.digital_board (resources\/views\/frontend\/digital_board.blade.php)",
                    "param_count": 0,
                    "params": [],
                    "type": "blade",
                    "editorLink": "phpstorm:\/\/open?file=\/home\/palikae\/demoerp.palikaerp.com\/resources\/views\/frontend\/digital_board.blade.php&line=0"
                }, {
                    "name": "components.frontend.scroll-news-component (resources\/views\/components\/frontend\/scroll-news-component.blade.php)",
                    "param_count": 10,
                    "params": ["scrollNews", "componentName", "attributes", "resolve", "flushCache",
                        "forgetFactory", "forgetComponentsResolver", "resolveComponentsUsing", "slot",
                        "__laravel_slots"
                    ],
                    "type": "blade",
                    "editorLink": "phpstorm:\/\/open?file=\/home\/palikae\/demoerp.palikaerp.com\/resources\/views\/components\/frontend\/scroll-news-component.blade.php&line=0"
                }, {
                    "name": "components.frontend.citizen-charter-component (resources\/views\/components\/frontend\/citizen-charter-component.blade.php)",
                    "param_count": 10,
                    "params": ["citizenCharters", "componentName", "attributes", "resolve", "flushCache",
                        "forgetFactory", "forgetComponentsResolver", "resolveComponentsUsing", "slot",
                        "__laravel_slots"
                    ],
                    "type": "blade",
                    "editorLink": "phpstorm:\/\/open?file=\/home\/palikae\/demoerp.palikaerp.com\/resources\/views\/components\/frontend\/citizen-charter-component.blade.php&line=0"
                }, {
                    "name": "components.frontend.digital-board-video-component (resources\/views\/components\/frontend\/digital-board-video-component.blade.php)",
                    "param_count": 10,
                    "params": ["videos", "componentName", "attributes", "resolve", "flushCache",
                        "forgetFactory", "forgetComponentsResolver", "resolveComponentsUsing", "slot",
                        "__laravel_slots"
                    ],
                    "type": "blade",
                    "editorLink": "phpstorm:\/\/open?file=\/home\/palikae\/demoerp.palikaerp.com\/resources\/views\/components\/frontend\/digital-board-video-component.blade.php&line=0"
                }, {
                    "name": "components.frontend.program-component (resources\/views\/components\/frontend\/program-component.blade.php)",
                    "param_count": 10,
                    "params": ["programs", "componentName", "attributes", "resolve", "flushCache",
                        "forgetFactory", "forgetComponentsResolver", "resolveComponentsUsing", "slot",
                        "__laravel_slots"
                    ],
                    "type": "blade",
                    "editorLink": "phpstorm:\/\/open?file=\/home\/palikae\/demoerp.palikaerp.com\/resources\/views\/components\/frontend\/program-component.blade.php&line=0"
                }, {
                    "name": "components.frontend.employee-section-component (resources\/views\/components\/frontend\/employee-section-component.blade.php)",
                    "param_count": 11,
                    "params": ["employees", "representatives", "componentName", "attributes", "resolve",
                        "flushCache", "forgetFactory", "forgetComponentsResolver",
                        "resolveComponentsUsing", "slot", "__laravel_slots"
                    ],
                    "type": "blade",
                    "editorLink": "phpstorm:\/\/open?file=\/home\/palikae\/demoerp.palikaerp.com\/resources\/views\/components\/frontend\/employee-section-component.blade.php&line=0"
                }, {
                    "name": "components.frontend.popup-notice-component (resources\/views\/components\/frontend\/popup-notice-component.blade.php)",
                    "param_count": 10,
                    "params": ["popupSetting", "componentName", "attributes", "resolve", "flushCache",
                        "forgetFactory", "forgetComponentsResolver", "resolveComponentsUsing", "slot",
                        "__laravel_slots"
                    ],
                    "type": "blade",
                    "editorLink": "phpstorm:\/\/open?file=\/home\/palikae\/demoerp.palikaerp.com\/resources\/views\/components\/frontend\/popup-notice-component.blade.php&line=0"
                }, {
                    "name": "frontend.layouts.master (resources\/views\/frontend\/layouts\/master.blade.php)",
                    "param_count": 7,
                    "params": ["__env", "app", "sharedCommittees", "officeSetting", "important_links",
                        "errors", "component"
                    ],
                    "type": "blade",
                    "editorLink": "phpstorm:\/\/open?file=\/home\/palikae\/demoerp.palikaerp.com\/resources\/views\/frontend\/layouts\/master.blade.php&line=0"
                }, {
                    "name": "frontend.partials.header_middle (resources\/views\/frontend\/partials\/header_middle.blade.php)",
                    "param_count": 7,
                    "params": ["__env", "app", "sharedCommittees", "officeSetting", "important_links",
                        "errors", "component"
                    ],
                    "type": "blade",
                    "editorLink": "phpstorm:\/\/open?file=\/home\/palikae\/demoerp.palikaerp.com\/resources\/views\/frontend\/partials\/header_middle.blade.php&line=0"
                }, {
                    "name": "components.header-component (resources\/views\/components\/header-component.blade.php)",
                    "param_count": 24,
                    "params": ["headers", "year", "month", "day", "hasClock", "componentName", "attributes",
                        "month_name", "resolve", "flushCache", "forgetFactory",
                        "forgetComponentsResolver", "resolveComponentsUsing", "triMonthlyQuarters",
                        "quarters", "get_nepali_date", "get_today_nepali_date", "get_eng_date",
                        "getNepaliMonthName", "getNepaliWeekName", "adToBsDate", "bsToAdDate", "slot",
                        "__laravel_slots"
                    ],
                    "type": "blade",
                    "editorLink": "phpstorm:\/\/open?file=\/home\/palikae\/demoerp.palikaerp.com\/resources\/views\/components\/header-component.blade.php&line=0"
                }, {
                    "name": "components.frontend.top-bar-date-component (resources\/views\/components\/frontend\/top-bar-date-component.blade.php)",
                    "param_count": 20,
                    "params": ["todayDate", "componentName", "attributes", "month_name", "resolve",
                        "flushCache", "forgetFactory", "forgetComponentsResolver",
                        "resolveComponentsUsing", "triMonthlyQuarters", "quarters", "get_nepali_date",
                        "get_today_nepali_date", "get_eng_date", "getNepaliMonthName",
                        "getNepaliWeekName", "adToBsDate", "bsToAdDate", "slot", "__laravel_slots"
                    ],
                    "type": "blade",
                    "editorLink": "phpstorm:\/\/open?file=\/home\/palikae\/demoerp.palikaerp.com\/resources\/views\/components\/frontend\/top-bar-date-component.blade.php&line=0"
                }, {
                    "name": "frontend.partials.digital_board_footer (resources\/views\/frontend\/partials\/digital_board_footer.blade.php)",
                    "param_count": 7,
                    "params": ["__env", "app", "sharedCommittees", "officeSetting", "important_links",
                        "errors", "component"
                    ],
                    "type": "blade",
                    "editorLink": "phpstorm:\/\/open?file=\/home\/palikae\/demoerp.palikaerp.com\/resources\/views\/frontend\/partials\/digital_board_footer.blade.php&line=0"
                }, {
                    "name": "sweetalert::alert (resources\/views\/vendor\/sweetalert\/alert.blade.php)",
                    "param_count": 7,
                    "params": ["__env", "app", "sharedCommittees", "officeSetting", "important_links",
                        "errors", "component"
                    ],
                    "type": "blade",
                    "editorLink": "phpstorm:\/\/open?file=\/home\/palikae\/demoerp.palikaerp.com\/resources\/views\/vendor\/sweetalert\/alert.blade.php&line=0"
                }]
            },
            "route": {
                "uri": "GET \/",
                "middleware": "web",
                "controller": "App\\Http\\Controllers\\FrontController@index",
                "namespace": null,
                "prefix": "",
                "where": [],
                "as": "welcome",
                "file": "<a href=\"phpstorm:\/\/open?file=\/home\/palikae\/demoerp.palikaerp.com\/app\/Http\/Controllers\/FrontController.php&line=24\">app\/Http\/Controllers\/FrontController.php:24-56<\/a>"
            },
            "queries": {
                "nb_statements": 14,
                "nb_failed_statements": 0,
                "accumulated_duration": 0.013750000000000002,
                "accumulated_duration_str": "13.75ms",
                "statements": [{
                    "sql": "select * from `office_settings` where `ward_no` is null and `office_settings`.`deleted_at` is null limit 1",
                    "type": "query",
                    "params": [],
                    "bindings": [],
                    "hints": null,
                    "show_copy": false,
                    "backtrace": [{
                        "index": 15,
                        "namespace": null,
                        "name": "\/app\/Helper\/helper.php",
                        "line": 45
                    }, {
                        "index": 17,
                        "namespace": null,
                        "name": "\/app\/Http\/Controllers\/Controller.php",
                        "line": 20
                    }, {
                        "index": 18,
                        "namespace": null,
                        "name": "\/app\/Http\/Controllers\/FrontController.php",
                        "line": 20
                    }, {
                        "index": 20,
                        "namespace": null,
                        "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/Container\/Container.php",
                        "line": 929
                    }, {
                        "index": 21,
                        "namespace": null,
                        "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/Container\/Container.php",
                        "line": 770
                    }],
                    "duration": 0.0012,
                    "duration_str": "1.2ms",
                    "stmt_id": "\/app\/Helper\/helper.php:45",
                    "connection": "palikae_demoerp",
                    "start_percent": 0,
                    "width_percent": 8.727
                }, {
                    "sql": "select * from `important_links` where `important_links`.`deleted_at` is null",
                    "type": "query",
                    "params": [],
                    "bindings": [],
                    "hints": null,
                    "show_copy": false,
                    "backtrace": [{
                        "index": 15,
                        "namespace": null,
                        "name": "\/app\/Http\/Controllers\/FrontController.php",
                        "line": 21
                    }, {
                        "index": 17,
                        "namespace": null,
                        "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/Container\/Container.php",
                        "line": 929
                    }, {
                        "index": 18,
                        "namespace": null,
                        "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/Container\/Container.php",
                        "line": 770
                    }, {
                        "index": 19,
                        "namespace": null,
                        "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Application.php",
                        "line": 856
                    }, {
                        "index": 20,
                        "namespace": null,
                        "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/Container\/Container.php",
                        "line": 706
                    }],
                    "duration": 0.0008,
                    "duration_str": "800\u03bcs",
                    "stmt_id": "\/app\/Http\/Controllers\/FrontController.php:21",
                    "connection": "palikae_demoerp",
                    "start_percent": 8.727,
                    "width_percent": 5.818
                }, {
                    "sql": "select * from `notices` where (`type` = 'News' and `closed_at` is null and ((FIND_IN_SET('', ward) > 0) or (`ward` is null)) or `is_displayed` = 1) and `notices`.`deleted_at` is null order by `date` desc",
                    "type": "query",
                    "params": [],
                    "bindings": ["News", "1"],
                    "hints": null,
                    "show_copy": false,
                    "backtrace": [{
                        "index": 14,
                        "namespace": null,
                        "name": "\/app\/View\/Components\/Frontend\/ScrollNewsComponent.php",
                        "line": 25
                    }, {
                        "index": 16,
                        "namespace": null,
                        "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/Container\/Container.php",
                        "line": 929
                    }, {
                        "index": 17,
                        "namespace": null,
                        "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/Container\/Container.php",
                        "line": 770
                    }, {
                        "index": 18,
                        "namespace": null,
                        "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Application.php",
                        "line": 856
                    }, {
                        "index": 19,
                        "namespace": null,
                        "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/Container\/Container.php",
                        "line": 706
                    }],
                    "duration": 0.00126,
                    "duration_str": "1.26ms",
                    "stmt_id": "\/app\/View\/Components\/Frontend\/ScrollNewsComponent.php:25",
                    "connection": "palikae_demoerp",
                    "start_percent": 14.545,
                    "width_percent": 9.164
                }, {
                    "sql": "select * from `citizen_charters` where (`is_displayed` = 1) and `citizen_charters`.`deleted_at` is null order by `branch_id` asc",
                    "type": "query",
                    "params": [],
                    "bindings": ["1"],
                    "hints": null,
                    "show_copy": false,
                    "backtrace": [{
                        "index": 14,
                        "namespace": null,
                        "name": "\/app\/View\/Components\/Frontend\/CitizenCharterComponent.php",
                        "line": 24
                    }, {
                        "index": 16,
                        "namespace": null,
                        "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/Container\/Container.php",
                        "line": 929
                    }, {
                        "index": 17,
                        "namespace": null,
                        "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/Container\/Container.php",
                        "line": 770
                    }, {
                        "index": 18,
                        "namespace": null,
                        "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Application.php",
                        "line": 856
                    }, {
                        "index": 19,
                        "namespace": null,
                        "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/Container\/Container.php",
                        "line": 706
                    }],
                    "duration": 0.00315,
                    "duration_str": "3.15ms",
                    "stmt_id": "\/app\/View\/Components\/Frontend\/CitizenCharterComponent.php:24",
                    "connection": "palikae_demoerp",
                    "start_percent": 23.709,
                    "width_percent": 22.909
                }, {
                    "sql": "select * from `branches` where `branches`.`id` in (3, 5, 6, 7, 8, 10, 11, 12) and `branches`.`deleted_at` is null",
                    "type": "query",
                    "params": [],
                    "bindings": [],
                    "hints": null,
                    "show_copy": false,
                    "backtrace": [{
                        "index": 19,
                        "namespace": null,
                        "name": "\/app\/View\/Components\/Frontend\/CitizenCharterComponent.php",
                        "line": 24
                    }, {
                        "index": 21,
                        "namespace": null,
                        "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/Container\/Container.php",
                        "line": 929
                    }, {
                        "index": 22,
                        "namespace": null,
                        "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/Container\/Container.php",
                        "line": 770
                    }, {
                        "index": 23,
                        "namespace": null,
                        "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Application.php",
                        "line": 856
                    }, {
                        "index": 24,
                        "namespace": null,
                        "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/Container\/Container.php",
                        "line": 706
                    }],
                    "duration": 0.001,
                    "duration_str": "1ms",
                    "stmt_id": "\/app\/View\/Components\/Frontend\/CitizenCharterComponent.php:24",
                    "connection": "palikae_demoerp",
                    "start_percent": 46.618,
                    "width_percent": 7.273
                }, {
                    "sql": "select `video` from `videos` where `status` = 1 and (`is_displayed` = 1) and `videos`.`deleted_at` is null order by `created_at` desc",
                    "type": "query",
                    "params": [],
                    "bindings": ["1", "1"],
                    "hints": null,
                    "show_copy": false,
                    "backtrace": [{
                        "index": 13,
                        "namespace": null,
                        "name": "\/app\/View\/Components\/Frontend\/DigitalBoardVideoComponent.php",
                        "line": 26
                    }, {
                        "index": 15,
                        "namespace": null,
                        "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/Container\/Container.php",
                        "line": 929
                    }, {
                        "index": 16,
                        "namespace": null,
                        "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/Container\/Container.php",
                        "line": 770
                    }, {
                        "index": 17,
                        "namespace": null,
                        "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Application.php",
                        "line": 856
                    }, {
                        "index": 18,
                        "namespace": null,
                        "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/Container\/Container.php",
                        "line": 706
                    }],
                    "duration": 0.00061,
                    "duration_str": "610\u03bcs",
                    "stmt_id": "\/app\/View\/Components\/Frontend\/DigitalBoardVideoComponent.php:26",
                    "connection": "palikae_demoerp",
                    "start_percent": 53.891,
                    "width_percent": 4.436
                }, {
                    "sql": "select * from `programs` where `status` = 1 and (`is_displayed` = 1) and `programs`.`deleted_at` is null order by `created_at` desc, `date` desc",
                    "type": "query",
                    "params": [],
                    "bindings": ["1", "1"],
                    "hints": null,
                    "show_copy": false,
                    "backtrace": [{
                        "index": 14,
                        "namespace": null,
                        "name": "\/app\/View\/Components\/Frontend\/ProgramComponent.php",
                        "line": 25
                    }, {
                        "index": 16,
                        "namespace": null,
                        "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/Container\/Container.php",
                        "line": 929
                    }, {
                        "index": 17,
                        "namespace": null,
                        "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/Container\/Container.php",
                        "line": 770
                    }, {
                        "index": 18,
                        "namespace": null,
                        "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Application.php",
                        "line": 856
                    }, {
                        "index": 19,
                        "namespace": null,
                        "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/Container\/Container.php",
                        "line": 706
                    }],
                    "duration": 0.00066,
                    "duration_str": "660\u03bcs",
                    "stmt_id": "\/app\/View\/Components\/Frontend\/ProgramComponent.php:25",
                    "connection": "palikae_demoerp",
                    "start_percent": 58.327,
                    "width_percent": 4.8
                }, {
                    "sql": "select * from `employees` where `status` = 1 and `show_to_index` = 1 and (`is_displayed` = 1) and `employees`.`deleted_at` is null order by `position` asc",
                    "type": "query",
                    "params": [],
                    "bindings": ["1", "1", "1"],
                    "hints": null,
                    "show_copy": false,
                    "backtrace": [{
                        "index": 14,
                        "namespace": null,
                        "name": "\/app\/View\/Components\/Frontend\/EmployeeSectionComponent.php",
                        "line": 46
                    }, {
                        "index": 16,
                        "namespace": null,
                        "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/Container\/Container.php",
                        "line": 929
                    }, {
                        "index": 17,
                        "namespace": null,
                        "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/Container\/Container.php",
                        "line": 770
                    }, {
                        "index": 18,
                        "namespace": null,
                        "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Application.php",
                        "line": 856
                    }, {
                        "index": 19,
                        "namespace": null,
                        "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/Container\/Container.php",
                        "line": 706
                    }],
                    "duration": 0.00083,
                    "duration_str": "830\u03bcs",
                    "stmt_id": "\/app\/View\/Components\/Frontend\/EmployeeSectionComponent.php:46",
                    "connection": "palikae_demoerp",
                    "start_percent": 63.127,
                    "width_percent": 6.036
                }, {
                    "sql": "select * from `pop_up_notices` where exists (select * from `popup_activations` where `pop_up_notices`.`id` = `popup_activations`.`pop_up_notice_id` and `popup_activations`.`deleted_at` is null) and (`is_displayed` = 1) and `is_active` = 1 order by `created_at` desc limit 1",
                    "type": "query",
                    "params": [],
                    "bindings": ["1", "1"],
                    "hints": null,
                    "show_copy": false,
                    "backtrace": [{
                        "index": 15,
                        "namespace": null,
                        "name": "\/app\/View\/Components\/Frontend\/PopupNoticeComponent.php",
                        "line": 28
                    }, {
                        "index": 16,
                        "namespace": null,
                        "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/View\/Component.php",
                        "line": 102
                    }, {
                        "index": 17,
                        "namespace": "view",
                        "name": "frontend.digital_board",
                        "line": 103
                    }, {
                        "index": 19,
                        "namespace": null,
                        "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/Filesystem\/Filesystem.php",
                        "line": 110
                    }, {
                        "index": 20,
                        "namespace": null,
                        "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/View\/Engines\/PhpEngine.php",
                        "line": 58
                    }],
                    "duration": 0.0009,
                    "duration_str": "900\u03bcs",
                    "stmt_id": "\/app\/View\/Components\/Frontend\/PopupNoticeComponent.php:28",
                    "connection": "palikae_demoerp",
                    "start_percent": 69.164,
                    "width_percent": 6.545
                }, {
                    "sql": "select * from `office_settings` where `ward_no` is null and `office_settings`.`deleted_at` is null limit 1",
                    "type": "query",
                    "params": [],
                    "bindings": [],
                    "hints": null,
                    "show_copy": false,
                    "backtrace": [{
                        "index": 15,
                        "namespace": null,
                        "name": "\/app\/Helper\/helper.php",
                        "line": 45
                    }, {
                        "index": 18,
                        "namespace": null,
                        "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/Filesystem\/Filesystem.php",
                        "line": 110
                    }, {
                        "index": 19,
                        "namespace": null,
                        "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/View\/Engines\/PhpEngine.php",
                        "line": 58
                    }, {
                        "index": 20,
                        "namespace": null,
                        "name": "\/vendor\/livewire\/livewire\/src\/ComponentConcerns\/RendersLivewireComponents.php",
                        "line": 69
                    }, {
                        "index": 21,
                        "namespace": null,
                        "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/View\/Engines\/CompilerEngine.php",
                        "line": 70
                    }],
                    "duration": 0.00063,
                    "duration_str": "630\u03bcs",
                    "stmt_id": "\/app\/Helper\/helper.php:45",
                    "connection": "palikae_demoerp",
                    "start_percent": 75.709,
                    "width_percent": 4.582
                }, {
                    "sql": "select * from `office_headers` where (`ward` is null) and `office_headers`.`deleted_at` is null order by `position` asc",
                    "type": "query",
                    "params": [],
                    "bindings": [],
                    "hints": null,
                    "show_copy": false,
                    "backtrace": [{
                        "index": 14,
                        "namespace": null,
                        "name": "\/app\/View\/Components\/HeaderComponent.php",
                        "line": 35
                    }, {
                        "index": 16,
                        "namespace": null,
                        "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/Container\/Container.php",
                        "line": 929
                    }, {
                        "index": 17,
                        "namespace": null,
                        "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/Container\/Container.php",
                        "line": 770
                    }, {
                        "index": 18,
                        "namespace": null,
                        "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Application.php",
                        "line": 856
                    }, {
                        "index": 19,
                        "namespace": null,
                        "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/Container\/Container.php",
                        "line": 706
                    }],
                    "duration": 0.0007099999999999999,
                    "duration_str": "710\u03bcs",
                    "stmt_id": "\/app\/View\/Components\/HeaderComponent.php:35",
                    "connection": "palikae_demoerp",
                    "start_percent": 80.291,
                    "width_percent": 5.164
                }, {
                    "sql": "select * from `office_settings` where `ward_no` is null and `office_settings`.`deleted_at` is null limit 1",
                    "type": "query",
                    "params": [],
                    "bindings": [],
                    "hints": null,
                    "show_copy": false,
                    "backtrace": [{
                        "index": 15,
                        "namespace": null,
                        "name": "\/app\/Helper\/helper.php",
                        "line": 45
                    }, {
                        "index": 18,
                        "namespace": null,
                        "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/Filesystem\/Filesystem.php",
                        "line": 110
                    }, {
                        "index": 19,
                        "namespace": null,
                        "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/View\/Engines\/PhpEngine.php",
                        "line": 58
                    }, {
                        "index": 20,
                        "namespace": null,
                        "name": "\/vendor\/livewire\/livewire\/src\/ComponentConcerns\/RendersLivewireComponents.php",
                        "line": 69
                    }, {
                        "index": 21,
                        "namespace": null,
                        "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/View\/Engines\/CompilerEngine.php",
                        "line": 70
                    }],
                    "duration": 0.00069,
                    "duration_str": "690\u03bcs",
                    "stmt_id": "\/app\/Helper\/helper.php:45",
                    "connection": "palikae_demoerp",
                    "start_percent": 85.455,
                    "width_percent": 5.018
                }, {
                    "sql": "select * from `office_settings` where `ward_no` is null and `office_settings`.`deleted_at` is null limit 1",
                    "type": "query",
                    "params": [],
                    "bindings": [],
                    "hints": null,
                    "show_copy": false,
                    "backtrace": [{
                        "index": 15,
                        "namespace": null,
                        "name": "\/app\/Helper\/helper.php",
                        "line": 45
                    }, {
                        "index": 18,
                        "namespace": null,
                        "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/Filesystem\/Filesystem.php",
                        "line": 110
                    }, {
                        "index": 19,
                        "namespace": null,
                        "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/View\/Engines\/PhpEngine.php",
                        "line": 58
                    }, {
                        "index": 20,
                        "namespace": null,
                        "name": "\/vendor\/livewire\/livewire\/src\/ComponentConcerns\/RendersLivewireComponents.php",
                        "line": 69
                    }, {
                        "index": 21,
                        "namespace": null,
                        "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/View\/Engines\/CompilerEngine.php",
                        "line": 70
                    }],
                    "duration": 0.00065,
                    "duration_str": "650\u03bcs",
                    "stmt_id": "\/app\/Helper\/helper.php:45",
                    "connection": "palikae_demoerp",
                    "start_percent": 90.473,
                    "width_percent": 4.727
                }, {
                    "sql": "select * from `office_settings` where `ward_no` is null and `office_settings`.`deleted_at` is null limit 1",
                    "type": "query",
                    "params": [],
                    "bindings": [],
                    "hints": null,
                    "show_copy": false,
                    "backtrace": [{
                        "index": 15,
                        "namespace": null,
                        "name": "\/app\/Helper\/helper.php",
                        "line": 45
                    }, {
                        "index": 18,
                        "namespace": null,
                        "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/Filesystem\/Filesystem.php",
                        "line": 110
                    }, {
                        "index": 19,
                        "namespace": null,
                        "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/View\/Engines\/PhpEngine.php",
                        "line": 58
                    }, {
                        "index": 20,
                        "namespace": null,
                        "name": "\/vendor\/livewire\/livewire\/src\/ComponentConcerns\/RendersLivewireComponents.php",
                        "line": 69
                    }, {
                        "index": 21,
                        "namespace": null,
                        "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/View\/Engines\/CompilerEngine.php",
                        "line": 70
                    }],
                    "duration": 0.00066,
                    "duration_str": "660\u03bcs",
                    "stmt_id": "\/app\/Helper\/helper.php:45",
                    "connection": "palikae_demoerp",
                    "start_percent": 95.2,
                    "width_percent": 4.8
                }]
            },
            "models": {
                "data": {
                    "App\\Models\\OfficeHeader": 3,
                    "App\\Models\\Settings\\Employee": 7,
                    "Modules\\DigitalBoard\\Entities\\Program": 7,
                    "App\\Models\\Settings\\Branch": 5,
                    "Modules\\DigitalBoard\\Entities\\CitizenCharter": 53,
                    "Modules\\DigitalBoard\\Entities\\Notice": 16,
                    "App\\Models\\Settings\\OfficeSetting": 5
                },
                "count": 96
            },
            "livewire": {
                "data": [],
                "count": 0
            },
            "gate": {
                "count": 0,
                "messages": []
            },
            "session": {
                "_token": "WbOhY6LmjYcxSeV6XQkHmTUgatonj57icH2Ztx2v",
                "url": "array:1 [\n  \"intended\" => \"https:\/\/demoerp.palikaerp.com\/admin\/dashboard\"\n]",
                "_previous": "array:1 [\n  \"url\" => \"https:\/\/demoerp.palikaerp.com\"\n]",
                "_flash": "array:2 [\n  \"old\" => []\n  \"new\" => []\n]",
                "PHPDEBUGBAR_STACK_DATA": "[]"
            },
            "request": {
                "path_info": "\/",
                "status_code": "<pre class=sf-dump id=sf-dump-2129192351 data-indent-pad=\"  \"><span class=sf-dump-num>200<\/span>\n<\/pre><script>Sfdump(\"sf-dump-2129192351\", {\"maxDepth\":0})<\/script>\n",
                "status_text": "OK",
                "format": "html",
                "content_type": "text\/html; charset=UTF-8",
                "request_query": "<pre class=sf-dump id=sf-dump-1735086667 data-indent-pad=\"  \">[]\n<\/pre><script>Sfdump(\"sf-dump-1735086667\", {\"maxDepth\":0})<\/script>\n",
                "request_request": "<pre class=sf-dump id=sf-dump-235687371 data-indent-pad=\"  \">[]\n<\/pre><script>Sfdump(\"sf-dump-235687371\", {\"maxDepth\":0})<\/script>\n",
                "request_headers": "<pre class=sf-dump id=sf-dump-904119044 data-indent-pad=\"  \"><span class=sf-dump-note>array:15<\/span> [<samp data-depth=1 class=sf-dump-expanded>\n  \"<span class=sf-dump-key>cookie<\/span>\" => <span class=sf-dump-note>array:1<\/span> [<samp data-depth=2 class=sf-dump-compact>\n    <span class=sf-dump-index>0<\/span> => \"<span class=sf-dump-str title=\"721 characters\">XSRF-TOKEN=eyJpdiI6IjRGNFd0WXlqRkxRbXJLWG1xVGltTHc9PSIsInZhbHVlIjoidGtnR2NwT1U5YkJYd1BOT2I3SFhmVFV4M3lMNXR6UGJkMHF6QXF0TlpyS0ZKNFI4TGMyMUd5aWVrZXJZR2JHVkxyQ0x0eDNoQ0J2N2xkZkRLRmVoUTM3WUFQTHlxQkJCQ2lZWThjK3c1TG9JK1JzREhsc1dMVHZQbUVCS1VmeHEiLCJtYWMiOiJjODFmODI0ZjA1ZTk3YjNjYWFhZjg5ZGVjY2ZkMTUwYzQ1YmY0YzM5NDc3YjNiNDMyZWFmM2UwMDBlZmZmYjYwIiwidGFnIjoiIn0%3D; digital_epalika_session=eyJpdiI6Ii9FdXJEUHFVM1kwbDNzeEhqZ25OTXc9PSIsInZhbHVlIjoiVUltSzR3K3VKcjZxVmVMVUV4eWxZZmlObU5pa1R5OVduMDZ0MklLVGp3UGJYb1F4S1JXbTZEc0s3MjZLbjROQTlzSlNaSnpVOEp3ajVidnZrK1Q5N0pPb0IxUWFDajJEc3d4NjZhTDhhOXFXSWYxQlRyd2Y5UnRLallWTnNNUkciLCJtYWMiOiJiMzFhYjcyODFiOGMzMThkMWY4MjYyN2IyMGEwNDlmOTFhNmZjNDAzNzc2OTA0YTA5YTE1M2NmY2RiZjYzMWI4IiwidGFnIjoiIn0%3D<\/span>\"\n  <\/samp>]\n  \"<span class=sf-dump-key>accept-language<\/span>\" => <span class=sf-dump-note>array:1<\/span> [<samp data-depth=2 class=sf-dump-compact>\n    <span class=sf-dump-index>0<\/span> => \"<span class=sf-dump-str title=\"14 characters\">en-US,en;q=0.9<\/span>\"\n  <\/samp>]\n  \"<span class=sf-dump-key>accept-encoding<\/span>\" => <span class=sf-dump-note>array:1<\/span> [<samp data-depth=2 class=sf-dump-compact>\n    <span class=sf-dump-index>0<\/span> => \"<span class=sf-dump-str title=\"23 characters\">gzip, deflate, br, zstd<\/span>\"\n  <\/samp>]\n  \"<span class=sf-dump-key>sec-fetch-dest<\/span>\" => <span class=sf-dump-note>array:1<\/span> [<samp data-depth=2 class=sf-dump-compact>\n    <span class=sf-dump-index>0<\/span> => \"<span class=sf-dump-str title=\"8 characters\">document<\/span>\"\n  <\/samp>]\n  \"<span class=sf-dump-key>sec-fetch-user<\/span>\" => <span class=sf-dump-note>array:1<\/span> [<samp data-depth=2 class=sf-dump-compact>\n    <span class=sf-dump-index>0<\/span> => \"<span class=sf-dump-str title=\"2 characters\">?1<\/span>\"\n  <\/samp>]\n  \"<span class=sf-dump-key>sec-fetch-mode<\/span>\" => <span class=sf-dump-note>array:1<\/span> [<samp data-depth=2 class=sf-dump-compact>\n    <span class=sf-dump-index>0<\/span> => \"<span class=sf-dump-str title=\"8 characters\">navigate<\/span>\"\n  <\/samp>]\n  \"<span class=sf-dump-key>sec-fetch-site<\/span>\" => <span class=sf-dump-note>array:1<\/span> [<samp data-depth=2 class=sf-dump-compact>\n    <span class=sf-dump-index>0<\/span> => \"<span class=sf-dump-str title=\"4 characters\">none<\/span>\"\n  <\/samp>]\n  \"<span class=sf-dump-key>accept<\/span>\" => <span class=sf-dump-note>array:1<\/span> [<samp data-depth=2 class=sf-dump-compact>\n    <span class=sf-dump-index>0<\/span> => \"<span class=sf-dump-str title=\"135 characters\">text\/html,application\/xhtml+xml,application\/xml;q=0.9,image\/avif,image\/webp,image\/apng,*\/*;q=0.8,application\/signed-exchange;v=b3;q=0.7<\/span>\"\n  <\/samp>]\n  \"<span class=sf-dump-key>user-agent<\/span>\" => <span class=sf-dump-note>array:1<\/span> [<samp data-depth=2 class=sf-dump-compact>\n    <span class=sf-dump-index>0<\/span> => \"<span class=sf-dump-str title=\"101 characters\">Mozilla\/5.0 (X11; Linux x86_64) AppleWebKit\/537.36 (KHTML, like Gecko) Chrome\/131.0.0.0 Safari\/537.36<\/span>\"\n  <\/samp>]\n  \"<span class=sf-dump-key>upgrade-insecure-requests<\/span>\" => <span class=sf-dump-note>array:1<\/span> [<samp data-depth=2 class=sf-dump-compact>\n    <span class=sf-dump-index>0<\/span> => \"<span class=sf-dump-str>1<\/span>\"\n  <\/samp>]\n  \"<span class=sf-dump-key>sec-ch-ua-platform<\/span>\" => <span class=sf-dump-note>array:1<\/span> [<samp data-depth=2 class=sf-dump-compact>\n    <span class=sf-dump-index>0<\/span> => \"<span class=sf-dump-str title=\"7 characters\">&quot;Linux&quot;<\/span>\"\n  <\/samp>]\n  \"<span class=sf-dump-key>sec-ch-ua-mobile<\/span>\" => <span class=sf-dump-note>array:1<\/span> [<samp data-depth=2 class=sf-dump-compact>\n    <span class=sf-dump-index>0<\/span> => \"<span class=sf-dump-str title=\"2 characters\">?0<\/span>\"\n  <\/samp>]\n  \"<span class=sf-dump-key>sec-ch-ua<\/span>\" => <span class=sf-dump-note>array:1<\/span> [<samp data-depth=2 class=sf-dump-compact>\n    <span class=sf-dump-index>0<\/span> => \"<span class=sf-dump-str title=\"65 characters\">&quot;Google Chrome&quot;;v=&quot;131&quot;, &quot;Chromium&quot;;v=&quot;131&quot;, &quot;Not_A Brand&quot;;v=&quot;24&quot;<\/span>\"\n  <\/samp>]\n  \"<span class=sf-dump-key>connection<\/span>\" => <span class=sf-dump-note>array:1<\/span> [<samp data-depth=2 class=sf-dump-compact>\n    <span class=sf-dump-index>0<\/span> => \"<span class=sf-dump-str title=\"10 characters\">keep-alive<\/span>\"\n  <\/samp>]\n  \"<span class=sf-dump-key>host<\/span>\" => <span class=sf-dump-note>array:1<\/span> [<samp data-depth=2 class=sf-dump-compact>\n    <span class=sf-dump-index>0<\/span> => \"<span class=sf-dump-str title=\"21 characters\">demoerp.palikaerp.com<\/span>\"\n  <\/samp>]\n<\/samp>]\n<\/pre><script>Sfdump(\"sf-dump-904119044\", {\"maxDepth\":0})<\/script>\n",
                "request_server": "<pre class=sf-dump id=sf-dump-417416848 data-indent-pad=\"  \"><span class=sf-dump-note>array:55<\/span> [<samp data-depth=1 class=sf-dump-expanded>\n  \"<span class=sf-dump-key>PATH<\/span>\" => \"<span class=sf-dump-str title=\"49 characters\">\/usr\/local\/sbin:\/usr\/local\/bin:\/usr\/sbin:\/usr\/bin<\/span>\"\n  \"<span class=sf-dump-key>TEMP<\/span>\" => \"<span class=sf-dump-str title=\"17 characters\">\/home\/palikae\/tmp<\/span>\"\n  \"<span class=sf-dump-key>TMPDIR<\/span>\" => \"<span class=sf-dump-str title=\"17 characters\">\/home\/palikae\/tmp<\/span>\"\n  \"<span class=sf-dump-key>TMP<\/span>\" => \"<span class=sf-dump-str title=\"17 characters\">\/home\/palikae\/tmp<\/span>\"\n  \"<span class=sf-dump-key>HOSTNAME<\/span>\" => \"\"\n  \"<span class=sf-dump-key>USER<\/span>\" => \"<span class=sf-dump-str title=\"7 characters\">palikae<\/span>\"\n  \"<span class=sf-dump-key>HOME<\/span>\" => \"<span class=sf-dump-str title=\"13 characters\">\/home\/palikae<\/span>\"\n  \"<span class=sf-dump-key>SCRIPT_NAME<\/span>\" => \"<span class=sf-dump-str title=\"17 characters\">\/public\/index.php<\/span>\"\n  \"<span class=sf-dump-key>REQUEST_URI<\/span>\" => \"<span class=sf-dump-str>\/<\/span>\"\n  \"<span class=sf-dump-key>QUERY_STRING<\/span>\" => \"\"\n  \"<span class=sf-dump-key>REQUEST_METHOD<\/span>\" => \"<span class=sf-dump-str title=\"3 characters\">GET<\/span>\"\n  \"<span class=sf-dump-key>SERVER_PROTOCOL<\/span>\" => \"<span class=sf-dump-str title=\"8 characters\">HTTP\/1.1<\/span>\"\n  \"<span class=sf-dump-key>GATEWAY_INTERFACE<\/span>\" => \"<span class=sf-dump-str title=\"7 characters\">CGI\/1.1<\/span>\"\n  \"<span class=sf-dump-key>REDIRECT_URL<\/span>\" => \"<span class=sf-dump-str>\/<\/span>\"\n  \"<span class=sf-dump-key>REMOTE_PORT<\/span>\" => \"<span class=sf-dump-str title=\"5 characters\">51744<\/span>\"\n  \"<span class=sf-dump-key>SCRIPT_FILENAME<\/span>\" => \"<span class=sf-dump-str title=\"52 characters\">\/home\/palikae\/demoerp.palikaerp.com\/public\/index.php<\/span>\"\n  \"<span class=sf-dump-key>SERVER_ADMIN<\/span>\" => \"<span class=sf-dump-str title=\"31 characters\">webmaster@demoerp.palikaerp.com<\/span>\"\n  \"<span class=sf-dump-key>CONTEXT_DOCUMENT_ROOT<\/span>\" => \"<span class=sf-dump-str title=\"35 characters\">\/home\/palikae\/demoerp.palikaerp.com<\/span>\"\n  \"<span class=sf-dump-key>CONTEXT_PREFIX<\/span>\" => \"\"\n  \"<span class=sf-dump-key>REQUEST_SCHEME<\/span>\" => \"<span class=sf-dump-str title=\"5 characters\">https<\/span>\"\n  \"<span class=sf-dump-key>DOCUMENT_ROOT<\/span>\" => \"<span class=sf-dump-str title=\"35 characters\">\/home\/palikae\/demoerp.palikaerp.com<\/span>\"\n  \"<span class=sf-dump-key>REMOTE_ADDR<\/span>\" => \"<span class=sf-dump-str title=\"15 characters\">103.235.197.229<\/span>\"\n  \"<span class=sf-dump-key>SERVER_PORT<\/span>\" => \"<span class=sf-dump-str title=\"3 characters\">443<\/span>\"\n  \"<span class=sf-dump-key>SERVER_ADDR<\/span>\" => \"<span class=sf-dump-str title=\"11 characters\">172.16.3.39<\/span>\"\n  \"<span class=sf-dump-key>SERVER_NAME<\/span>\" => \"<span class=sf-dump-str title=\"21 characters\">demoerp.palikaerp.com<\/span>\"\n  \"<span class=sf-dump-key>SERVER_SOFTWARE<\/span>\" => \"<span class=sf-dump-str title=\"46 characters\">Apache\/2.4.57 (Unix) OpenSSL\/1.1.1k PHP\/8.2.25<\/span>\"\n  \"<span class=sf-dump-key>SERVER_SIGNATURE<\/span>\" => \"\"\n  \"<span class=sf-dump-key>LD_LIBRARY_PATH<\/span>\" => \"<span class=sf-dump-str title=\"21 characters\">\/usr\/local\/apache\/lib<\/span>\"\n  \"<span class=sf-dump-key>HTTP_COOKIE<\/span>\" => \"<span class=sf-dump-str title=\"721 characters\">XSRF-TOKEN=eyJpdiI6IjRGNFd0WXlqRkxRbXJLWG1xVGltTHc9PSIsInZhbHVlIjoidGtnR2NwT1U5YkJYd1BOT2I3SFhmVFV4M3lMNXR6UGJkMHF6QXF0TlpyS0ZKNFI4TGMyMUd5aWVrZXJZR2JHVkxyQ0x0eDNoQ0J2N2xkZkRLRmVoUTM3WUFQTHlxQkJCQ2lZWThjK3c1TG9JK1JzREhsc1dMVHZQbUVCS1VmeHEiLCJtYWMiOiJjODFmODI0ZjA1ZTk3YjNjYWFhZjg5ZGVjY2ZkMTUwYzQ1YmY0YzM5NDc3YjNiNDMyZWFmM2UwMDBlZmZmYjYwIiwidGFnIjoiIn0%3D; digital_epalika_session=eyJpdiI6Ii9FdXJEUHFVM1kwbDNzeEhqZ25OTXc9PSIsInZhbHVlIjoiVUltSzR3K3VKcjZxVmVMVUV4eWxZZmlObU5pa1R5OVduMDZ0MklLVGp3UGJYb1F4S1JXbTZEc0s3MjZLbjROQTlzSlNaSnpVOEp3ajVidnZrK1Q5N0pPb0IxUWFDajJEc3d4NjZhTDhhOXFXSWYxQlRyd2Y5UnRLallWTnNNUkciLCJtYWMiOiJiMzFhYjcyODFiOGMzMThkMWY4MjYyN2IyMGEwNDlmOTFhNmZjNDAzNzc2OTA0YTA5YTE1M2NmY2RiZjYzMWI4IiwidGFnIjoiIn0%3D<\/span>\"\n  \"<span class=sf-dump-key>HTTP_ACCEPT_LANGUAGE<\/span>\" => \"<span class=sf-dump-str title=\"14 characters\">en-US,en;q=0.9<\/span>\"\n  \"<span class=sf-dump-key>HTTP_ACCEPT_ENCODING<\/span>\" => \"<span class=sf-dump-str title=\"23 characters\">gzip, deflate, br, zstd<\/span>\"\n  \"<span class=sf-dump-key>HTTP_SEC_FETCH_DEST<\/span>\" => \"<span class=sf-dump-str title=\"8 characters\">document<\/span>\"\n  \"<span class=sf-dump-key>HTTP_SEC_FETCH_USER<\/span>\" => \"<span class=sf-dump-str title=\"2 characters\">?1<\/span>\"\n  \"<span class=sf-dump-key>HTTP_SEC_FETCH_MODE<\/span>\" => \"<span class=sf-dump-str title=\"8 characters\">navigate<\/span>\"\n  \"<span class=sf-dump-key>HTTP_SEC_FETCH_SITE<\/span>\" => \"<span class=sf-dump-str title=\"4 characters\">none<\/span>\"\n  \"<span class=sf-dump-key>HTTP_ACCEPT<\/span>\" => \"<span class=sf-dump-str title=\"135 characters\">text\/html,application\/xhtml+xml,application\/xml;q=0.9,image\/avif,image\/webp,image\/apng,*\/*;q=0.8,application\/signed-exchange;v=b3;q=0.7<\/span>\"\n  \"<span class=sf-dump-key>HTTP_USER_AGENT<\/span>\" => \"<span class=sf-dump-str title=\"101 characters\">Mozilla\/5.0 (X11; Linux x86_64) AppleWebKit\/537.36 (KHTML, like Gecko) Chrome\/131.0.0.0 Safari\/537.36<\/span>\"\n  \"<span class=sf-dump-key>HTTP_UPGRADE_INSECURE_REQUESTS<\/span>\" => \"<span class=sf-dump-str>1<\/span>\"\n  \"<span class=sf-dump-key>HTTP_SEC_CH_UA_PLATFORM<\/span>\" => \"<span class=sf-dump-str title=\"7 characters\">&quot;Linux&quot;<\/span>\"\n  \"<span class=sf-dump-key>HTTP_SEC_CH_UA_MOBILE<\/span>\" => \"<span class=sf-dump-str title=\"2 characters\">?0<\/span>\"\n  \"<span class=sf-dump-key>HTTP_SEC_CH_UA<\/span>\" => \"<span class=sf-dump-str title=\"65 characters\">&quot;Google Chrome&quot;;v=&quot;131&quot;, &quot;Chromium&quot;;v=&quot;131&quot;, &quot;Not_A Brand&quot;;v=&quot;24&quot;<\/span>\"\n  \"<span class=sf-dump-key>HTTP_CONNECTION<\/span>\" => \"<span class=sf-dump-str title=\"10 characters\">keep-alive<\/span>\"\n  \"<span class=sf-dump-key>HTTP_HOST<\/span>\" => \"<span class=sf-dump-str title=\"21 characters\">demoerp.palikaerp.com<\/span>\"\n  \"<span class=sf-dump-key>proxy-nokeepalive<\/span>\" => \"<span class=sf-dump-str>1<\/span>\"\n  \"<span class=sf-dump-key>SSL_TLS_SNI<\/span>\" => \"<span class=sf-dump-str title=\"21 characters\">demoerp.palikaerp.com<\/span>\"\n  \"<span class=sf-dump-key>HTTPS<\/span>\" => \"<span class=sf-dump-str title=\"2 characters\">on<\/span>\"\n  \"<span class=sf-dump-key>UNIQUE_ID<\/span>\" => \"<span class=sf-dump-str title=\"27 characters\">Zz2z3IbojIe0gKWGtMLWsAAAAYU<\/span>\"\n  \"<span class=sf-dump-key>REDIRECT_STATUS<\/span>\" => \"<span class=sf-dump-str title=\"3 characters\">200<\/span>\"\n  \"<span class=sf-dump-key>REDIRECT_SSL_TLS_SNI<\/span>\" => \"<span class=sf-dump-str title=\"21 characters\">demoerp.palikaerp.com<\/span>\"\n  \"<span class=sf-dump-key>REDIRECT_HTTPS<\/span>\" => \"<span class=sf-dump-str title=\"2 characters\">on<\/span>\"\n  \"<span class=sf-dump-key>REDIRECT_UNIQUE_ID<\/span>\" => \"<span class=sf-dump-str title=\"27 characters\">Zz2z3IbojIe0gKWGtMLWsAAAAYU<\/span>\"\n  \"<span class=sf-dump-key>FCGI_ROLE<\/span>\" => \"<span class=sf-dump-str title=\"9 characters\">RESPONDER<\/span>\"\n  \"<span class=sf-dump-key>PHP_SELF<\/span>\" => \"<span class=sf-dump-str title=\"17 characters\">\/public\/index.php<\/span>\"\n  \"<span class=sf-dump-key>REQUEST_TIME_FLOAT<\/span>\" => <span class=sf-dump-num>1732096988.5428<\/span>\n  \"<span class=sf-dump-key>REQUEST_TIME<\/span>\" => <span class=sf-dump-num>1732096988<\/span>\n<\/samp>]\n<\/pre><script>Sfdump(\"sf-dump-417416848\", {\"maxDepth\":0})<\/script>\n",
                "request_cookies": "<pre class=sf-dump id=sf-dump-1782005092 data-indent-pad=\"  \"><span class=sf-dump-note>array:2<\/span> [<samp data-depth=1 class=sf-dump-expanded>\n  \"<span class=sf-dump-key>XSRF-TOKEN<\/span>\" => \"<span class=sf-dump-str title=\"40 characters\">WbOhY6LmjYcxSeV6XQkHmTUgatonj57icH2Ztx2v<\/span>\"\n  \"<span class=sf-dump-key>digital_epalika_session<\/span>\" => \"<span class=sf-dump-str title=\"40 characters\">zMcJNt9qQVDmFOZIpgdwfdLwL1n5kbpEp0SzkGsY<\/span>\"\n<\/samp>]\n<\/pre><script>Sfdump(\"sf-dump-1782005092\", {\"maxDepth\":0})<\/script>\n",
                "response_headers": "<pre class=sf-dump id=sf-dump-759486597 data-indent-pad=\"  \"><span class=sf-dump-note>array:5<\/span> [<samp data-depth=1 class=sf-dump-expanded>\n  \"<span class=sf-dump-key>content-type<\/span>\" => <span class=sf-dump-note>array:1<\/span> [<samp data-depth=2 class=sf-dump-compact>\n    <span class=sf-dump-index>0<\/span> => \"<span class=sf-dump-str title=\"24 characters\">text\/html; charset=UTF-8<\/span>\"\n  <\/samp>]\n  \"<span class=sf-dump-key>cache-control<\/span>\" => <span class=sf-dump-note>array:1<\/span> [<samp data-depth=2 class=sf-dump-compact>\n    <span class=sf-dump-index>0<\/span> => \"<span class=sf-dump-str title=\"17 characters\">no-cache, private<\/span>\"\n  <\/samp>]\n  \"<span class=sf-dump-key>date<\/span>\" => <span class=sf-dump-note>array:1<\/span> [<samp data-depth=2 class=sf-dump-compact>\n    <span class=sf-dump-index>0<\/span> => \"<span class=sf-dump-str title=\"29 characters\">Wed, 20 Nov 2024 10:03:08 GMT<\/span>\"\n  <\/samp>]\n  \"<span class=sf-dump-key>set-cookie<\/span>\" => <span class=sf-dump-note>array:2<\/span> [<samp data-depth=2 class=sf-dump-compact>\n    <span class=sf-dump-index>0<\/span> => \"<span class=sf-dump-str title=\"436 characters\">XSRF-TOKEN=eyJpdiI6IklZUUlhcGpjZndtb2J6MEJwTGFaNnc9PSIsInZhbHVlIjoiUnZSKy9CUy9LK2RRVkxlaDY2c0VKK29pUEVjeGpnTTc5c3QzMldocDNYWXFhWkptYkEzd1Z4eHE0MlFodHFDRExPRFhpZFVKL0xUL0h6NEl0U00yOHBEU0FGS3VhZkdwQ2FYUFZQQzZvZUVqbmtWak1UUXAxaDBKS3BmbmEvNjciLCJtYWMiOiI3YWFlODBiODM4ZWVkN2U2Y2Y5NmJhM2JjMzZhZGZlZmJiOWQyZmFmOGFkNTM2MjczOGQ0OGFkOWY5MDhjZWU2IiwidGFnIjoiIn0%3D; expires=Wed, 20 Nov 2024 12:03:08 GMT; Max-Age=7200; path=\/; secure; samesite=lax<\/span>\"\n    <span class=sf-dump-index>1<\/span> => \"<span class=sf-dump-str title=\"406 characters\">digital_epalika_session=eyJpdiI6InRWTmZJbTdVVlZXK3k1bmg2NWszTUE9PSIsInZhbHVlIjoia29qKzc0cWxpNm5rSThrYXhucTZzSDhzb0JwL08yYjU5OFZsOVE0em9OMlRSMDBKdTZOTGduNDdURGRYYVR2UWhDNjFuSTFZZlJtNWU3cnFETXlUWUN5YWp6bi96OG5WL0hWV1ZMbU8xV2E3ckZqVVI4VUxWQU1vVEhOMWh1VGciLCJtYWMiOiJjNDRhNmI4ODVmYWViNWQ2YzRmMGQ3Zjk4YjkyZTNiYmEyNTEyOGU4MzcxYjJkNjMyYWEwYzY3MzQ0MmQ4ZDQ4IiwidGFnIjoiIn0%3D; path=\/; secure; httponly; samesite=lax<\/span>\"\n  <\/samp>]\n  \"<span class=sf-dump-key>Set-Cookie<\/span>\" => <span class=sf-dump-note>array:2<\/span> [<samp data-depth=2 class=sf-dump-compact>\n    <span class=sf-dump-index>0<\/span> => \"<span class=sf-dump-str title=\"408 characters\">XSRF-TOKEN=eyJpdiI6IklZUUlhcGpjZndtb2J6MEJwTGFaNnc9PSIsInZhbHVlIjoiUnZSKy9CUy9LK2RRVkxlaDY2c0VKK29pUEVjeGpnTTc5c3QzMldocDNYWXFhWkptYkEzd1Z4eHE0MlFodHFDRExPRFhpZFVKL0xUL0h6NEl0U00yOHBEU0FGS3VhZkdwQ2FYUFZQQzZvZUVqbmtWak1UUXAxaDBKS3BmbmEvNjciLCJtYWMiOiI3YWFlODBiODM4ZWVkN2U2Y2Y5NmJhM2JjMzZhZGZlZmJiOWQyZmFmOGFkNTM2MjczOGQ0OGFkOWY5MDhjZWU2IiwidGFnIjoiIn0%3D; expires=Wed, 20-Nov-2024 12:03:08 GMT; path=\/; secure<\/span>\"\n    <span class=sf-dump-index>1<\/span> => \"<span class=sf-dump-str title=\"392 characters\">digital_epalika_session=eyJpdiI6InRWTmZJbTdVVlZXK3k1bmg2NWszTUE9PSIsInZhbHVlIjoia29qKzc0cWxpNm5rSThrYXhucTZzSDhzb0JwL08yYjU5OFZsOVE0em9OMlRSMDBKdTZOTGduNDdURGRYYVR2UWhDNjFuSTFZZlJtNWU3cnFETXlUWUN5YWp6bi96OG5WL0hWV1ZMbU8xV2E3ckZqVVI4VUxWQU1vVEhOMWh1VGciLCJtYWMiOiJjNDRhNmI4ODVmYWViNWQ2YzRmMGQ3Zjk4YjkyZTNiYmEyNTEyOGU4MzcxYjJkNjMyYWEwYzY3MzQ0MmQ4ZDQ4IiwidGFnIjoiIn0%3D; path=\/; secure; httponly<\/span>\"\n  <\/samp>]\n<\/samp>]\n<\/pre><script>Sfdump(\"sf-dump-759486597\", {\"maxDepth\":0})<\/script>\n",
                "session_attributes": "<pre class=sf-dump id=sf-dump-223088998 data-indent-pad=\"  \"><span class=sf-dump-note>array:5<\/span> [<samp data-depth=1 class=sf-dump-expanded>\n  \"<span class=sf-dump-key>_token<\/span>\" => \"<span class=sf-dump-str title=\"40 characters\">WbOhY6LmjYcxSeV6XQkHmTUgatonj57icH2Ztx2v<\/span>\"\n  \"<span class=sf-dump-key>url<\/span>\" => <span class=sf-dump-note>array:1<\/span> [<samp data-depth=2 class=sf-dump-compact>\n    \"<span class=sf-dump-key>intended<\/span>\" => \"<span class=sf-dump-str title=\"45 characters\">https:\/\/demoerp.palikaerp.com\/admin\/dashboard<\/span>\"\n  <\/samp>]\n  \"<span class=sf-dump-key>_previous<\/span>\" => <span class=sf-dump-note>array:1<\/span> [<samp data-depth=2 class=sf-dump-compact>\n    \"<span class=sf-dump-key>url<\/span>\" => \"<span class=sf-dump-str title=\"29 characters\">https:\/\/demoerp.palikaerp.com<\/span>\"\n  <\/samp>]\n  \"<span class=sf-dump-key>_flash<\/span>\" => <span class=sf-dump-note>array:2<\/span> [<samp data-depth=2 class=sf-dump-compact>\n    \"<span class=sf-dump-key>old<\/span>\" => []\n    \"<span class=sf-dump-key>new<\/span>\" => []\n  <\/samp>]\n  \"<span class=sf-dump-key>PHPDEBUGBAR_STACK_DATA<\/span>\" => []\n<\/samp>]\n<\/pre><script>Sfdump(\"sf-dump-223088998\", {\"maxDepth\":0})<\/script>\n"
            }
        }, "X6ca05b514f3ed474fb7fb237d3f280c4");
    </script>
</body>

</html>
