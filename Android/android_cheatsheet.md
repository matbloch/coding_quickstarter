# Android dev

## Layouts

**Storage path:** `res/layout/`


```html
<LinearLayout xmlns:android="http://schemas.android.com/apk/res/android">
</LinearLayout>
```



### Linear layout


| property | value |
|--------|--------|
|`layout_width` | width       |
|`layout_height`| height |

**custom values**

| value | effect |
|--------|--------|
|`match_parent` | auto expand      |



```html
<LinearLayout xmlns:android="http://schemas.android.com/apk/res/android"
    xmlns:tools="http://schemas.android.com/tools"
    android:layout_width="match_parent"
    android:layout_height="match_parent"
    android:orientation="horizontal" >
</LinearLayout>
```


## UI-Elements

### Buttons


### Text fields `<EditText>`

```html
<EditText android:id="@+id/edit_message"
    android:layout_width="wrap_content"
    android:layout_height="wrap_content"
    android:hint="@string/edit_message" />
```
