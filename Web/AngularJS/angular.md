# AngularJS


## Basic Structure




## AngularJS & Jinja (Flask)

**Conflict:** Both engines use `{{..}}` as an entry point for code
**Solution:** Enclose sections to ignore by Jinja with `raw` tag
```php
{% raw %}
	angularjs Code
{% endraw %}
```