Hi, here's your problem today. This problem was recently asked by Uber:

Find the maximum number of connected colors in a grid.

class Grid:
  def __init__(self, grid):
    self.grid = grid

  def max_connected_colors(self):
    # Fill this in.

grid = [[1, 0, 0, 1],
        [1, 1, 1, 1],
        [0, 1, 0, 0]]

print(Grid(grid).max_connected_colors())
# 7

Can you solve this both recursively and iteratively?
