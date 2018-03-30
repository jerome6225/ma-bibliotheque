<div id="sidebar">
    <div id="panels">
        <input id="searchBox" placeholder="search" type="search">
        <a id="show-Search" class="show_view icon-search" data-view="Search">Search</a>
        <a id="show-Toc" class="show_view icon-list-1 active" data-view="Toc">TOC</a>
        <a id="show-Bookmarks" class="show_view icon-bookmark" data-view="Bookmarks">Bookmarks</a>
        <a id="show-Notes" class="show_view icon-edit" data-view="Notes">Notes</a>
    </div>
    <div id="tocView" class="view"></div>
    <div id="searchView" class="view">
        <ul id="searchResults"></ul>
    </div>
    <div id="bookmarksView" class="view">
        <ul id="bookmarks"></ul>
    </div>
    <div id="notesView" class="view">
        <div id="new-note">
            <textarea id="note-text"></textarea>
            <button id="note-anchor">Anchor</button>
        </div>
        <ol id="notes"></ol>
    </div>
</div>
<div id="main">
    <div id="titlebar">
        <div id="opener">
            <a id="slider" class="icon-menu">Menu</a>
        </div>
        <div id="metainfo">
            <span id="book-title"></span>
            <span id="title-seperator">&nbsp;&nbsp;–&nbsp;&nbsp;</span>
            <span id="chapter-title"></span>
        </div>
        <div id="title-controls">
            <a id="bookmark" class="icon-bookmark-empty">Bookmark</a>
            <a id="setting" class="icon-cog">Settings</a>
            <a id="fullscreen" class="icon-resize-full">Fullscreen</a>
            <a id="no_read_book">X</a>
        </div>
    </div>
    <div id="divider"></div>
    <div id="prev" class="arrow">‹</div>
    <div id="viewer"></div>
    <div id="next" class="arrow">›</div>
    <div id="loader"><img src="img/loader.gif"></div>
</div>
<div class="modal md-effect-1" id="settings-modal">
    <div class="md-content">
        <h3>Settings</h3>
        <div>
            <p>
                <input type="checkbox" id="sidebarReflow" name="sidebarReflow">Reflow text when sidebars are open.
            </p>
        </div>
        <div class="closer icon-cancel-circled"></div>
    </div>
</div>