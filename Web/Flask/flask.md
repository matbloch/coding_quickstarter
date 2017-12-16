


## Forms (Flask-WTForms)


### Custom Fields

Example:
"""python

class FolderRendererWidget(object):
    _js = """alert('{} says: Torresmo eh mto da hora.');"""
    html_params = staticmethod(html_params)

    def __init__(self, input_type='submit', text=''):
        self.input_type = input_type
        self.text = text

    def __call__(self, field, **kwargs):
        kwargs.setdefault('id', field.id)
        # if hasattr(field, 'users'):
        #     html = [u'<ul %s>' % html_params(id=field.id)]
        #     # A sure hope users is iterable:
        #     for u in field.users:
        #         params = dict(kwargs, id=u['_id'], onclick=self._js.format(u['name']))
        #         html.append(u'<li %s>%s</li>' % (html_params(**params), u['name']))
        #     html.append('<li>TUKA EH + TORRESMO</li>')
        #     html.append(u'</ul>')
        # else:
        #     html = '<h1>Too bad, so sad</h1>'

		# option 1
        html = [u'<div %s>' % html_params(id=field.id)]
        html.append(u'stuff...')
        html.append(u'</div>')
        return u''.join(html)
		
		# option 2
		attributes = widgets.html_params(**kwargs)
		return widgets.HTMLString('<label %s>%s</label>' % (attributes, text or self.text))

		# option 3
		html = ['<%s %s>' % (self.html_tag, html_params(**kwargs))]
		for subfield in field:
			if self.prefix_label:
				html.append('<li>%s %s</li>' % (subfield.label, subfield()))
			else:
				html.append('<li>%s %s</li>' % (subfield(), subfield.label))
		html.append('</%s>' % self.html_tag)
		return HTMLString(''.join(html))


class CustomFolderSelect(Field):
    """
    Parent Class "Field" fields:
    - errors (error messages)
    - validators (validator)
    - widget (renderer)
    ........
    Arguments:

    ........
    Variables:
    - name
    - label
    - description
    - id
    - validators
    - filters

    """

    # renderer
    widget = FolderRendererWidget()

    # field data
    folder_path = None

    #  custom constructors
    def __init__(self, label=None, validators=None, **kwargs):
        super(CustomFolderSelect, self).__init__(label, validators, **kwargs)

    # preprocess form data (from updates)
    def process_formdata(self, valuelist):
        if valuelist:
            self.data = valuelist[0]
        else:
            self.data = ''

    # return value
    def _value(self):
        return text_type(self.data) if self.data is not None else ''

# the form
class NewDirectoryForm_new(FlaskForm):
    """
    Defines the form used to create a new Dataset
    (abstract class)
    """

    folder = CustomFolderSelect(id="mycstmid")

@directories.route('/new', methods=['GET', 'POST'])
def new():

    # form = NewDirectoryForm()
    # if form.validate_on_submit():
    #
    #     # init new directory job
    #
    #     # redirect
    #     return render_template(
    #         'directories/new.html',
    #         title='Scan new directory',
    #         form=form
    #     )

    # form = NewDirectoryForm()
    form = NewDirectoryForm_new()

    # load registration template
    return render_template(
        'page/directories/new.html',
        title='Scan new directory',
        form=form
    )



"""