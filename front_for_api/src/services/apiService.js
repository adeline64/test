export const get = async (url, onSuccess, onError = () => console.log('Error !')) => {
  const res = await fetch(`http://127.0.0.1:8000/api/${url}`)
  const data = await res.json()

  if (res.status === 200) {
    console.log(data['hydra:member']);
    onSuccess(data['hydra:member'])
  } else {
    onError
  }
}