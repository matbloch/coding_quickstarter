# Bugs



- [ ] Engine state is not reset when moving to mode menu
- [ ] Tracks highlights already appear during scanning phase
  - they are emitted but should be hidden

- [ ] Track highlights should disappear when on Tap - when we switch from tracking to moving
  - **engine fix:** reset was called on pointer, call clear

- [ ] Don't go into tracking if nothing is beeing tracked
  - **workaround:** switch state and restart timer if there are no tracked objects after scanning phase





----------------

- [ ] we scan in tracking mode
  - **reason:** supervisor still uses 80ms instead of inf







- [x] tracks are lost in tracking state
  - [x] **reason:** `applySettings` only works on new tracks, not existing ones
  - [x] **reason:** If homography fails, track fails

- [ ] UI: tracks are not removed if the tracker is reset (should be, because they listen to session and session is reset)



**Unexpected things**

- don't tap on barcode highlights, it's ment for selection

















