Slink
====

What is Slink?
----
Symfony2 bundle for making short links similar to http://Bit.ly, http://Goo.gl, http://Su.pr, etc. 

How to
----
1. Put the **SlinkBundle** into the **Bundle** folder (*<your_project>/src/SlinkBundle*). You can rename it as you want.
2. On your **AppKernel** put the next line
  ```
    <path_to_your_bundle_WITH_INVERTED_SLASHES>\<name_of_your_bundle>(),
  ```
  It should be something like this:

  ```
      $bundles = array(
        ....  
        ....
        new Dorin\Bundles\SlinkBundle\DorinBundlesSlinkBundle(),
      );
      ...
  ```

3. Configure the route file ( *<your_project>/app/config/routing.yml* ).
  ```
    dorin_bundles_slink:
      resource: "@<path_to_your_bundle_without_slashes/Controller/"
      type:     annotation
      prefix:   /
  ```
  In my case: 
  ```
    dorin_bundles_slink:
      resource: "@DorinBundlesSlinkBundle/Controller/"
      type:     annotation
      prefix:   /
  ```
In my case I used the next configuration and using annotation inside of the Controller for the routing. 

Author
----
Writed by Dorin Gheorghe Brage. Feel free to contact me if you found any bug or if you want to contribute you're free to do it. =)
