Hi, here's your problem today. This problem was recently asked by Facebook:

Reshaping a matrix means to take the same elements in a matrix but change the row and column length. This means that the new matrix needs to have the same elements filled in the same row order as the old matrix. Given a matrix, a new row size x and a new column size y, reshape the matrix. If it is not possible to reshape, return None.

Here's an example and some starter code.

def reshape_matrix(mat, x, y):
  # Fill this in.

print(reshape_matrix([[1, 2], [3, 4]], 1, 4))
# [[1], [2], [3], [4]]

print(reshape_matrix([[1, 2], [3, 4]], 2, 3))
# None
