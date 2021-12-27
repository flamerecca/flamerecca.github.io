## Effective Java 3e 讀書心得 - Item 2：Consider a builder when faced with many constructor parameters

當一個物件可能有非常多的屬性時，最直覺的想法就是在 constructor 加上很多的參數

```java
NutritionFacts cocaCola =
    new NutritionFacts(240, 8, 100, 35, 27);
```

這樣顯然不好維護，也難以在程式碼內看出參數的意義

其中一種改寫方式

是書中提到的 JavaBean Pattern

```java
NutritionFacts cocaCola = new NutritionFacts();
cocaCola.setServingSize(240);
cocaCola.setServings(8);
cocaCola.setCalories(100);
cocaCola.setSodium(35);
cocaCola.setCarbohydrate(27);
```

這樣可讀性提升不少，但是有一些缺點

像是這樣會導致 NutritionFacts 物件必定是可變（mutable）的

## Builder Pattern

如果我們加上一個 `Builder()` 類別

```java
public class NutritionFacts {
    private final int servingSize;
    private final int servings;
    private final int calories;
    private final int sodium;
    private final int carbohydrate;
    public static class Builder {
        private final int servingSize = 0;
	    private final int servings = 0;
	    private int calories      = 0;
	    private int sodium        = 0;
	    private int carbohydrate  = 0;
	    public Builder() {}
	    public Builder servingSize(int val) {
		    servingSize = val;
		    return this;
	    }
	    public Builder servings(int val) {
		    servings = val;
		    return this;
	    }
	    public Builder calories(int val) {
		    calories = val;
		    return this;
	    }
	    public Builder calories(int val) {
		    calories = val;
		    return this;
	    }
        public Builder sodium(int val) {
		    sodium = val;
		    return this;
	    }
        public Builder carbohydrate(int val) {
		    carbohydrate = val;
		    return this;
	    }
        public NutritionFacts build() {
            return new NutritionFacts(this);
        }
	}
    private NutritionFacts(Builder builder) {
        servingSize  = builder.servingSize;
        servings     = builder.servings;
        calories     = builder.calories;
        sodium       = builder.sodium;
        carbohydrate = builder.carbohydrate;
	}
}
```

使其使用方式如下

```java
NutritionFacts cocaCola = new NutritionFacts.Builder()
    .servingSize(240)
    .servings(8)
    .calories(100)
    .sodium(35)
    .carbohydrate(27)
    .build();
```

這樣一來，整體的可讀性會提升很多

並且避免掉前面所說 JavaBean Pattern 的問題。

## Kotlin 版本

要使用 Builder() 方式

會需要蠻多程式碼作為鋪墊來提升可讀性

書中提到

>The Builder pattern simulates named optional parameters as found in Python and Scala.

所以建構子參數過多難以維護這個問題

並不是所有語言都有

幸運的是， Kotlin 和 Python 或 Scala 一樣

支援 named optional parameters 

所以在 Kotlin 內，我們可以這樣寫

```kotlin
val cocaCola = NutritionFacts(
    servingSize = 240,
    servings = 8,
    calories = 100,
    sodium = 35,
    carbohydrate = 27)
```

不會犧牲可讀性，又能保持程式碼的整潔

----
回到[首頁](index.md)
