=== Better Redirects for Gravity Forms ===
Contributors: @xmic
Donate link: https://ko-fi.com/michaelsumner
Tags: gravity, forms, redirects, seo, 404, form, gf
Requires at least: 4.0
Requires PHP: 5.6
Tested up to: 5.7.2
Stable tag: 1.2.0
License: GPL-2.0+
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Avoids 404 errors in your form confirmation redirects. Specify your confirmation redirect URL, so that form redirects will never 404 again.

== Description ==

**Better Redirects for Gravity Forms** future-proofs your Gravity Forms confirmation redirect URL, so that if your redirect URL ever changes, you will still be able to redirect your users without 404 errors.

#### Zero-maintenance form confirmation redirect URLs

https://www.youtube.com/watch?v=I_YjONB65go

#### Simple setup

* Set your form to use a confirmation redirect within Gravity Forms, and specify the URL within the **Better Redirect** section whilst editing your form confirmation.

#### Never have to update a confirmation URL again

* When you update the URL permalink / slug, and it happens to be within a Gravity Form confirmation redirect URL, **Better Redirects for Gravity Forms** will automatically update all form confirmations containing the updated URL.

### Avoid 404 errors from your form internal redirect URLs for good 

* Because **Better Redirects for Gravity Forms** automatically updates the Gravity Forms form confirmation URLs for you, you will never have forms with broken confirmation URLs. No matter how many forms you have.

#### Good for Thank You pages

* **Thank You** pages are a common practice for confirmation redirect URLs upon successful form submission. You can rest assured that changing **Thank You** page URLs will be safe for your Gravity Forms.

#### Plugin support is readily available

* You can contact the plugin developer through the **Better Redirects for Gravity Forms** [Support forums](https://wordpress.org/support/plugin/better-redirects-for-gravity-forms/) for questions and issues you might have.

#### How is this plugin useful?

**Are you this guy:**

"I've changed the URL of a confirmation page... Now I have to go through the Gravity forms settings... and click around 5-10 times... for each form...".

**If you are... then you should be this guy instead:**

"I've installed **Better Redirects for Gravity Forms** that **automatically updates the confirmation page URL for me, across all Gravity forms that have that URL**. Life is good..."

#### Setup

1. Once this plugin is installed and activated, you can visit any of your **Gravity forms**, and within the **Settings** › **Confirmations**, select any confirmation (or create a new one).
2. Set your **Confirmation Type** as **Redirect**. You can leave the Redirect URL blank, we will change it in a minute.
3. Scroll to the bottom, you should find a section **Better Redirect**.
4. Now, click the button **Select Link**, and choose a link.
5. Once you have added the link, scroll to the bottom of the page, and click the button **Save Confirmation** to save this confirmation.
6. You have now saved the confirmation redirect so that when the specified URL updates in the future, **the URL will automatically update itself across all confirmations containing that URL**. This is awesome!

#### Support

* You can contact the plugin developer through the **Better Redirects for Gravity Forms** [Support forums](https://wordpress.org/support/plugin/better-redirects-for-gravity-forms/) for questions and issues you might have.

### Privacy Policy

**Better Redirects for Gravity Forms** does not collect any data. The confirmations, forms, urls are held within the Gravity Forms plugin.

== Installation ==

1. **Better Redirects for Gravity Forms** can be installed directly through your WordPress Plugins dashboard.
2. Click **Add New** and Search for **Better Redirects for Gravity Forms**
3. **Install** and **Activate**.

Alternatively you can download the plugin using the download button on this page and then upload the **better-redirects-for-gravity-forms** folder to the /wp-content/plugins/ directory then activate through the Plugins dashboard in WordPress.

== Frequently Asked Questions ==

= How does this plugin work? =

**Better Redirects for Gravity Forms** uses a combination of WordPress action hooks and Gravity Forms filters to find out if your forms have a **confirmation redirect URL** specified. So if you have a page / post / custom post type / taxonomy / front page / shop page / or any other link that you have updated within WordPress, your Gravity forms will still redirect to the proper URL.

= Does this work for external URLs? =

No, this does not work for external URLs. **Better Redirects for Gravity Forms** will have no trace that the external URL has been modified. If you require this feature, please submit it as a **customisation request** within the [Support forums](https://wordpress.org/support/plugin/better-redirects-for-gravity-forms/).

= Can I see your code? =

Yes, please visit the [GitHub repository link](https://github.com/michael-sumner/better-redirects-for-gravity-forms). Contributions for improvements are always welcome.

== Changelog ==

Please visit the [GitHub repository link](https://github.com/michael-sumner/better-redirects-for-gravity-forms) for the changelog.

== Screenshots ==

1. Find your Better Redirects in the Gravity Form here.
2. Let us set a Better Redirect for the specified Gravity form. Success! It successfully redirects!
3. Changing the redirect URL later on, will automatically save it across all your confirmations, on all forms that actively contain it.
4. If you remove the Better Redirect, your standard redirect will continue to function. This is useful if you want to use External link redirects.