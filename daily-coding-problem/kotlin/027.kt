class Solution {
    fun isValid(s: String): Boolean {
        var deque = ArrayDeque<Char>()

        for (i in 0..s.length-1) {
            var character = s.get(i)
            println(character)
            if (character == '(' || character == '[' || character == '{')  
            {
                deque.push(character)
                continue; 
            }
            if (deque.isEmpty()) {
                return false; 
            }
            when (character) {
                ')' -> if (deque.getFirst() == '(') {deque.pop()} else { return false }
                ']' -> if (deque.getFirst() == '[') {deque.pop()} else { return false }
                '}' -> if (deque.getFirst() == '{') {deque.pop()} else { return false }
                else -> return false
            }
        }
        if(!deque.isEmpty()){
            return false
        }
        return true
    }
}
