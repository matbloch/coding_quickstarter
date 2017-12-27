# Coding Styleguide for C++

## naming
- filenames: lowercase and can include underscores (_) or dashes (-). prefer "_"
- C++ file: `.cc`/`cpp`, header file: `.h`
- Classes/Types: start with a capital letter and have a capital letter for each new word, with no underscores
- Variables: lowercase, with underscores between words
- Class Data Members: might have trailing underscore
- `const` variables: "k" followed by mixed case (words start with uppercase)
- Functions: Regular functions have mixed case; "cheap" functions may use lower case with underscores.Acronyms: only first letter capilatlized

## Functions

- **Parameters**: 
	- first inputs, then outputs
	- All references (&ref) as `const`

## Variables
- use `const` whenever it makes sense: const variables, data members, methods and arguments
- 0 and nullptr/NULL: Use 0 for integers, 0.0 for reals, nullptr (or NULL) for pointers, and '\0' for chars.