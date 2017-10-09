# Static Asset Domain Replace

Joomla plugin to add a domain name to static assets.

Makes heavy use of advanced Regex.

## Features:

 - Replace only certain types of resources (e.x. only those in <script src> or only <img src> tags)
 - Replace only files with specific extension (e.x. only .jpg or only .min.js)
     - (.min.js and .js are considered different extensions by this plugin)
 - Use relative //, http:// or https:// for the replaced urls
 - Very simple and easy-to-modify code:
     - I tried to make this as straightforward and uncomplicated as possible, no external libraries or hidden functions.
     - No guarantee on your interpretation of the Regex though, that might still be complicated.
 - Operates on the final html output of a page
     - Doesn't modify any locations inside Joomla, only operates on the frontend output html of the site.
 - Works with caching plugins (just set the order before or after in Joomla)

Why this plugin exists:

### Alternative to "CDN for Joomla"

All I needed to do was change the domain of the static assets in tags like <script> and <link> or <style> to a CDN pull zone domain. So that's all this plugin does.

Since the "CDN for Joomla" plugin didn't have HTTP/s scheme support in the free version, this may be an improvement.

### To explicitly set the domain for static assets

Even if you're not serving from a separate domain, you can have the plugin insert whatever domain you want.

For example, you could change all the local resources to be http/s or not, or just ensure that they're all set.
