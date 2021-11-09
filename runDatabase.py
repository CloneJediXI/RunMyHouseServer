import functions
option = 0
 
while option != 5:
    option = input("1: Add Menu\n2: Removal Menu\n3: Print Menu\n4: Commit Changes\n5: Exit\n")
    
    if option=="1":
        functions.add_menu()
    elif option=="2":
        functions.removal_menu()
    elif option=="3":
        functions.print_menu()
    elif option=="4":
        functions.commit()
    elif option=="5":
        quit()
    else:
        print("Not a valid option.")
