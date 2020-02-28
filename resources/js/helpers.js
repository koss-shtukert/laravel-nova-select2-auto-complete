const isEmpty = (value => {
    return (value === undefined || value == null || value.length <= 0) ? true : false
})

export default isEmpty
