# Async Fetch

- see https://dmitripavlutin.com/javascript-fetch-async-await/



## Fetch

```tsx
async function fetchMovies() {
  const response = await fetch('/movies');
  // waits until the request completes...
  console.log(response);
}
```





**Extracting JSON**

- `json()` returns promise



```tsx
async function fetchMoviesJSON() {
  const response = await fetch('/movies');
  const movies = await response.json();
  console.log(await movies);
  // movies get's also wrapped in a premise
  return movies;
}

fetchMoviesJSON().then(movies => {
  movies; // fetched movies
});
```



## Handling Errors

- `fetch` doesn't throw an error on bad requests

```tsx
async function fetchMoviesBadStatus() {
  const response = await fetch('/oops');
  if (!response.ok) {    
      const message = `An error has occured: ${response.status}`;
      throw new Error(message);  
  }
  const movies = await response.json();
  // "movies" is available at this point since the previous call to "await" blocks
  console.log(movies);
  return movies;
}

fetchMoviesBadStatus().catch(error => {
  error.message; // 'An error has occurred: 404'
});
```





