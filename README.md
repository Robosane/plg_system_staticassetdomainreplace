# Static Asset Domain Replace

[Work in progress]

Joomla plugin to add a domain name to static assets.

Makes heavy use of advanced Regex.

## Features:

 - Replace only certain types of resources (e.x. only those in &lt;script src> or only &lt;img src> tags)
 - Replace only files with specific extension (e.x. only .jpg or only .min.js)
     - (.min.js and .js are considered different extensions by this plugin)
 - Use relative //, http:// or https:// for the replaced urls
 - Very simple and easy-to-modify code:
     - I tried to make this as straightforward and uncomplicated as possible, no external libraries or hidden functions.
     - No guarantee on your interpretation of the Regex though, that might still be complicated.
 - Operates on the final html output of a page
     - Doesn't modify any locations inside Joomla, only operates on the frontend output html of the site.
 - Works with caching plugins (just set the order before or after in Joomla)

Note: this plugin doesn't replace *relative* local urls, since that would require extracting information about the parent path. Meaning `templates/something.js` won't get replaced, but `/templates/something.js` will.

Why this plugin exists:

### Alternative to "CDN for Joomla" (My use case)

All I needed to do was change the domain of the static assets in tags like &lt;script> and &lt;link> or &lt;style> to a CDN pull zone domain. So that's all this plugin does.

Since the "CDN for Joomla" plugin didn't have HTTP/s scheme support in the free version, this may be an improvement.

For example, I have a javascript static resource (let's say jQuery,) that I wanted to serve from my CDN instead of my site. Since I use CloudFlare, the paths are the same on the CDN and the primary host. (/images on the CDN is /images on the origin)

Something like this in the html of the page:
```html
<script src="/templates/robosaneed24/js/jui/jquery.min.js?8f126dd35f491b86b38f69083a398410" type="text/javascript"></script>
<script src="/media/jui/js/jquery-noconflict.js?8f126dd35f491b86b38f69083a398410" type="text/javascript"></script>
<script src="/media/jui/js/jquery-migrate.min.js?8f126dd35f491b86b38f69083a398410" type="text/javascript"></script>
```
Using this plugin (domain: www-cdn.robosane.net, enable in script tags, filetypes: min.js, js)
Now gets served from the CDN instead:
```html
<script src="https://www-cdn.robosane.net/templates/robosaneed24/js/jui/jquery.min.js?8f126dd35f491b86b38f69083a398410" type="text/javascript"></script>
<script src="https://www-cdn.robosane.net/media/jui/js/jquery-noconflict.js?8f126dd35f491b86b38f69083a398410" type="text/javascript"></script>
<script src="https://www-cdn.robosane.net/media/jui/js/jquery-migrate.min.js?8f126dd35f491b86b38f69083a398410" type="text/javascript"></script>
```

If your CDN is in a subfolder, just change the domain to something like `your-cdn.domain.com/subfolder` and it'll work since it's just a regex replace.

I'm using this approach because it also separates the cookie domains from the CDN, so if you're a [performance snob](https://gtmetrix.com/use-cookie-free-domains.html) like me, or just prefer not to send passwords through the CDN (but still want to use one), then this plugin may help.

### To explicitly set the domain for static assets

Even if you're not serving from a separate domain, you can have the plugin insert whatever domain you want.

For example, you could change all the local resources to be http/s or not, or just ensure that they're all set.
