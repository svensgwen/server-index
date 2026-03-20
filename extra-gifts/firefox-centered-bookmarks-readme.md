# Firefox Centered Bookmarks Toolbar Fix

This tweak centers the Firefox bookmarks toolbar using `userChrome.css`.

## What this does

By default, Firefox keeps the bookmarks toolbar aligned in a way that
can feel stuck to the sides.\
This custom CSS makes the bookmarks appear centered in the toolbar.

## Requirements

-   Firefox
-   `toolkit.legacyUserProfileCustomizations.stylesheets` enabled in
    `about:config`

## Enable custom CSS in Firefox

1.  Open Firefox

2.  Go to `about:config`

3.  Search for:

    toolkit.legacyUserProfileCustomizations.stylesheets

4.  Set it to `true`

## Find your Firefox profile folder

1.  Open `about:support`
2.  Find **Profile Folder**
3.  Click **Open Directory**

## Create the chrome folder

Inside your Firefox profile folder, create a folder named:

chrome

## Create the CSS file

Inside the `chrome` folder, create this file:

userChrome.css

## CSS code

Paste this into `userChrome.css`:

``` css
/* Center the bookmarks toolbar */
#PersonalToolbar {
  display: flex !important;
  justify-content: center !important;
}

/* Prevent the bookmarks container from stretching */
#PlacesToolbarItems {
  display: inline-flex !important;
  width: auto !important;
  flex: 0 0 auto !important;
}

/* Stop the parent wrapper from taking full width */
#PersonalToolbar > toolbaritem {
  flex: 0 0 auto !important;
}

/* Optional spacing between bookmarks */
#PlacesToolbarItems > .bookmark-item {
  margin: 0 6px !important;
}
```

## Restart Firefox

After saving the file:

1.  Completely close Firefox
2.  Open it again

The bookmarks toolbar should now be centered.

## Optional debug

If the bookmarks still do not look centered, add this temporarily:

``` css
#PersonalToolbar {
  outline: 2px solid red !important;
}

#PlacesToolbarItems {
  outline: 2px solid blue !important;
}
```

## Notes

-   `userChrome.css` styles the Firefox interface, not websites
-   The folder is called `chrome` because in Firefox, "chrome" means the
    browser UI

## License

Free to use and modify.
