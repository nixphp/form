<div style="text-align: center;">

![Logo](https://nixphp.github.io/docs/assets/nixphp-logo-small-square.png)

[![NixPHP Form Plugin](https://github.com/nixphp/form/actions/workflows/php.yml/badge.svg)](https://github.com/nixphp/form/actions/workflows/php.yml)

</div>


[← Back to NixPHP](https://github.com/nixphp/framework)

---

# nixphp/form

> **Form handling done the NixPHP way — minimal, secure, and intuitive.**

This plugin provides **form memory helpers** and **CSRF protection** for your NixPHP application.
It integrates seamlessly and requires no configuration.

> 🧩 Part of the official NixPHP plugin collection.
> Install it when you need to handle form input and secure POST requests — nothing more.

---

## 📦 Features

* ✅ Form input memory: preserve user data between requests
* ✅ CSRF protection: validated automatically before controller calls
* ✅ Works out of the box, no configuration needed
* ✅ Clean view helpers for error display
* ✅ Registers its listener via plugin bootstrap

---

## 📥 Installation

```bash
composer require nixphp/form
```

That’s it. The plugin will be autoloaded and ready to use.

---

## 🚀 Usage

### 🧠 Preserve user input: `memory()`

Use the `memory()` helper in your views to repopulate form fields:

```php
<input type="text" name="email" value="<?= memory('email') ?>">
```

It automatically remembers the previous input after validation or redirects.

You can also check for general errors using:

```php
<?php if (formError('email')): ?>
    <p class="error"><?= formError('email') ?></p>
<?php endif; ?>
```

---

### 🛡️ CSRF Protection

CSRF validation is triggered **automatically** for `POST`, `PUT`, and `DELETE` requests
(unless the request contains an `Authorization` header).

To protect your forms, include a CSRF token:

```php
<form method="post">
    <input type="hidden" name="_csrf" value="<?= guard()->csrf()->generate() ?>">
    <!-- other fields -->
</form>
```

This will be validated before any controller logic is executed.

If the token is missing or invalid, a 400 error is returned.

---

## 🔍 Internals

* The plugin registers a listener to the `controller.calling` event to validate CSRF tokens.
* It also extends the `guard()` service to include a `csrf()` method.
* View helpers like `formError()` and `memory()` are automatically available.

---

## ✅ Requirements

* `nixphp/framework` >= 1.0
* `nixphp/session` (required for CSRF and memory state)

---

## 📄 License

MIT License.