翻譯自

https://www.facebook.com/notes/kent-beck/when-worse-is-better-incrementally-escaping-local-maxima/498576730175196/

----

在軟體設計的理想模型中，每個時候都存在一個或多個目標——可靠性、效能、可修改性等。對設計的變更可能會在這些方面上有所改變。每個變更都需要一些額外成本，因此希望變更盡量少，但每個變更也涉及風險，因此希望變更盡量小，但每個變更也創造價值，因此希望變更盡量大。在軟體設計中平衡成本、風險和進展是一門藝術。

如果您一直在閱讀我的文章，您會知道我的「Sprinting Centipede」策略是盡量減少每次變更的成本，以便幾乎連續地鏈接在一起進行小規模的變更。從外部看，明顯發生了大變化，即使從內部看，也清楚沒有任何個別的變更是巨大或有風險的。

One knock on this strategy is how it deals with the situation where incremental improvement is no longer possible, where the design has reached a local maximum. For example, suppose you have squeezed all the performance you can out of a single server and you need to shard the workload. This can be a large change to the software and can't be achieved by incremental improvements.

It's tempting to pull out a clean white sheet of paper when faced with a local maximum and a big trough. However, the risk compounds when replacing a large amount of functionality in one go. Do we have to give up the risk management advantages of incremental change just because have painted ourselves into a (mixed) metaphorical corner?

The problem is worse than it seems on the surface. If we have been making little incremental changes daily for months or years, our skills at de novo development will have atrophied. Not only are we putting a big bunch of functionality into production at once, we developed that functionality at less than 100%. Bad mojo.

The key is being able to abandon the other half of the phrase "incremental improvement". If we are willing to mindfully practice incremental degradation, then we can escape local maxima, travel through the Valley of Despair, and climb the new Mountain of Blessedness all without abandoning the safety of small steps. Here are some examples.

Suppose we have a class that is awkwardly factored into methods. Say there is 100 lines of logic, the coding standards demand no more than 10 lines per function, and someone took the original 100 line function and chopped it every 10 lines (I'm not smart enough to make this stuff up). What's the best way to get to a sensible set of helper methods? Incremental improvement is hard because related computations can easily be split between functions. Incremental degradation, though, is easy (especially with the right tools): inline everything until you have one gigantic, ugly function. With the, er..., stuff all in one pile, it's relatively easy to make incremental improvements.

Suppose we need to switch from one data store to another. Normalization is good, right? So the incremental way to convert is to denormalize. Everywhere we write to the old store, write to the new store. Bulk migrate all the old data. Begin reading from the new store and comparing results to make sure they match. When the error rate is acceptable, stop writing to the old store and decommission.

The literature and tools for incremental change betray a bias towards improvement. Fowler's "Refactoring" covers extracting methods more thoroughly than inlining them. Refactoring tools often implement varieties of extract before inline. To be fair, that's the more common direction to move. However, mastering incremental design demands being equally prepared to improve or degrade the design at any time, depending on whether it's possible to incrementally improve. In fact, sometimes when I have degraded the design and discover I still can't make incremental progress, I release my inner pig and make a really big mess.

簡單講：如果你不能讓它更好，那就讓它更糟
