Hi, here's your problem today. This problem was recently asked by Apple:

Given a list of undirected edges which represents a graph, find out the number of connected components.

def num_connected_components(edges):
	# Fill this in.

print(num_connected_components([(1, 2), (2, 3), (4, 1), (5, 6)]))
# 2

In the above example, vertices 1, 2, 3, 4 are all connected, and 5, 6 are connected, and thus there are 2 connected components in the graph above.
