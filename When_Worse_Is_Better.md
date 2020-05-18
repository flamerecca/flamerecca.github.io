翻譯自

https://www.facebook.com/notes/kent-beck/when-worse-is-better-incrementally-escaping-local-maxima/498576730175196/

----
在軟體設計的理想模型中，

In the optimization model of software design there are one or more goals in play at any one time--reliability, performance, modifiability, and so on. Changes to the design can move the design on one or more of these dimensions. Each change requires some overhead, and so you would like few changes, but each change also entails risk, so you would like the changes to be as small as possible, but each change creates value, so you would like changes to be as big as possible. Balancing cost, risk, and progress is the art of software design.

If you've been reading along, you will know that my Sprinting Centipede strategy is to reduce the cost of each change as much as possible so as to enable small changes to be chained together nearly continuously. From the outside it is clear that big changes are happening, even though from the inside it's clear that no individual change is large or risky.

One knock on this strategy is how it deals with the situation where incremental improvement is no longer possible, where the design has reached a local maximum. For example, suppose you have squeezed all the performance you can out of a single server and you need to shard the workload. This can be a large change to the software and can't be achieved by incremental improvements.

It's tempting to pull out a clean white sheet of paper when faced with a local maximum and a big trough. However, the risk compounds when replacing a large amount of functionality in one go. Do we have to give up the risk management advantages of incremental change just because have painted ourselves into a (mixed) metaphorical corner?

The problem is worse than it seems on the surface. If we have been making little incremental changes daily for months or years, our skills at de novo development will have atrophied. Not only are we putting a big bunch of functionality into production at once, we developed that functionality at less than 100%. Bad mojo.

The key is being able to abandon the other half of the phrase "incremental improvement". If we are willing to mindfully practice incremental degradation, then we can escape local maxima, travel through the Valley of Despair, and climb the new Mountain of Blessedness all without abandoning the safety of small steps. Here are some examples.

Suppose we have a class that is awkwardly factored into methods. Say there is 100 lines of logic, the coding standards demand no more than 10 lines per function, and someone took the original 100 line function and chopped it every 10 lines (I'm not smart enough to make this stuff up). What's the best way to get to a sensible set of helper methods? Incremental improvement is hard because related computations can easily be split between functions. Incremental degradation, though, is easy (especially with the right tools): inline everything until you have one gigantic, ugly function. With the, er..., stuff all in one pile, it's relatively easy to make incremental improvements.

Suppose we need to switch from one data store to another. Normalization is good, right? So the incremental way to convert is to denormalize. Everywhere we write to the old store, write to the new store. Bulk migrate all the old data. Begin reading from the new store and comparing results to make sure they match. When the error rate is acceptable, stop writing to the old store and decommission.

The literature and tools for incremental change betray a bias towards improvement. Fowler's "Refactoring" covers extracting methods more thoroughly than inlining them. Refactoring tools often implement varieties of extract before inline. To be fair, that's the more common direction to move. However, mastering incremental design demands being equally prepared to improve or degrade the design at any time, depending on whether it's possible to incrementally improve. In fact, sometimes when I have degraded the design and discover I still can't make incremental progress, I release my inner pig and make a really big mess.

簡單講：如果你不能讓它更好，那就讓它更糟
