def can_travel_to(game_matrix, from_row, from_column, to_row, to_column):
    # Check if destination is 1 step only
    if abs(from_row - to_row) + abs(from_column - to_column) != 1:
        return False

    # Check if destination is out of bounds
    if to_row < 0 or to_row >= len(game_matrix) or to_column < 0 or to_column >= len(game_matrix[0]):
        return False

    # Get destination value
    destination = game_matrix[to_row][to_column]

    # Check if destination is False
    if not destination:
        return False

    return True

if __name__ == "__main__":
    gameMatrix = [
        [False, True,  True,  False, False, False],
        [True,  True,  True,  False, False, False],
        [True,  True,  True,  True,  True,  True],
        [False, True,  True,  False, True,  True],
        [False, True,  True,  True,  False, True],
        [False, False, False, False, False, False],
    ]

    # Test cases
    print(can_travel_to(gameMatrix, 3, 2, 2, 2)) # True, Valid move
    print(can_travel_to(gameMatrix, 3, 2, 3, 4)) # False, Can't travel through land
    print(can_travel_to(gameMatrix, 3, 2, 6, 2)) # False, Out of bounds