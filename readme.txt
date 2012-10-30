=== Plugin Name ===
Contributors: nabla
Donate link: http://example.com/
Tags: table, excel, office, convert
Requires at least: 2.0.2
Tested up to: 3.3.1
Stable tag: 1.3

Convert Excel files to html standard tabel

== Description ==

Based on code from  php Excel Reader at http://code.google.com/p/php-excel-reader/ this simple 
plugin convert all excel files in a specified folder in html table. You can chose to use it to view a tabel in a page.

Let

    myFaboluosExcelFile.xls 

is the file you want to view as table

Upload it via plugin manager, than use the shortcode

    [excel_table fname="myFaboluosExcelFile"]

to put a html table wherever you want in a page.

This plugin also create a list of link of Excel file in a page where you put the tag 

    [excel_table] 

and when you open one of it you could see a page with the table

== Installation ==

To get this plugin working 

e.g.

1. Upload  folder `excel-2-table` to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Place Excel files in folder 'excel_file' inside path
1. Place shortcode in your templates

== Frequently Asked Questions ==

= Is this stable and proved =

No, I'm currently working on it (Jan 2012).

== Screenshots ==

1. Manager panel
2. link of files in post
3. View of example table

== Changelog ==
= 1.4 =
- Removed multiple sheet error

= 1.3 =
- Char encoding conversion fixed (almost) and solved some empty field

= 1.2 =
- Solved one BIG bug for Path

= 1.1 =

- Table shortcode introduced, now it is possible to link just one file in a page

- Changed logic for link creation (solved one bug)

= 1.0 =

- First release

== Upgrade Notice ==

I'm planning to introduce DB support in order to reduce computiational needs. Obviously 
i need transaltion, it's on my roadmap, but not now....
