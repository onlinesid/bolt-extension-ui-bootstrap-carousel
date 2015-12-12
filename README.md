# bolt-extension-ui-bootstrap-carousel
A simple Bootstrap Carousel generator for Bolt templates http://bolt.cm (adapted from https://github.com/GawainLynch/bolt-extension-bootstrap-carousel)

UI Bootstrap Carousel (Bolt.cm Extension)
=========================================

Credit: adapted from https://github.com/GawainLynch/bolt-extension-bootstrap-carousel

An extension to display a UI Bootstrap Carousel based on a Bolt Contenttype record.

    {{ uib_carousel('carousel_name') }}

Set up
------

1. Contenttype  
   Create a Contenttype similar to the one shown below.  The only compulsorary 
   thing is that the Contenttype **must** have a field of `type: imagelist`.
```
carousels:
    name: Carousels
    singular_name: Carousel
    fields:
        title:
            type: text
            group: content      
        slug:
            type: slug
            uses: [ title ]
        images:
            type: imagelist
    show_on_dashboard: false
    default_status: published
    searchable: false
    viewless: true    
```
   The contenttype (`carousel`) and images field (`images`) names are configurable, 
   as you will point to them in the configuration file.  
2. Record   
   Create a new 'Carousel' record in the backend, give is a descriptive title and 
   populate the images field.  
3. Configuration file  
   In the extension's configuration file you want to define the slider you will 
   call in your template, e.g.
```
    myslider:
        content: carousel/1
```
   The `content:` parameter uses the `{% setcontent %}` style of record definition
   and lookup.  In the above example it will return the record with contenttype 
   `slider` and the record ID of 1.  
4. Template file  
    In the location you want to display the slider in your template, add:  
```
    {{ uib_carousel('mycarousel') }}
```
