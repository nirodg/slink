Slink
====

What is Slink?
----
Symfony2 bundle for making short links similar to http://Bit.ly, http://Goo.gl, http://Su.pr, etc. 

How to
----

1. Put the **SlinkBundle** into the **Bundle** folder (*<your_project>/src/SlinkBundle*). You can rename it as you want. 
2. Configure the route file ( *<your_project>/app/config/routing.yml* ).
```
  dorin_bundles_slink:
    resource: "@DorinBundlesSlinkBundle/Controller/"
    type:     annotation
    prefix:   /
```
In my case I used the next configuration and using annotation inside of the Controller for the routing. 

Author
----
Writed by Dorin Gheorghe Brage
