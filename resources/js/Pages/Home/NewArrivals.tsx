import '../../../css/front/pages/home/new-arrivals.css';

const products = [
    {
        name: 'Concrete Hoodie',
        category: 'Outerwear',
        price: '$120',
        alt: 'Oversized hoodie',
        src: 'https://lh3.googleusercontent.com/aida-public/AB6AXuC-uCfpGUQjj_B-O-ID7opODxlHEtK2YYNyd7zoPo_xSmucDdPrM5fAZf6-_MZy4H1u_l95gireGCiElwpqhuFlQk9Djfnqaps0lfI-aOpsfMqGE-xfmRuGjG-3mE-eA1Q2Xxq3ITUnMQJr47EhTtvpd6Vo0fPp-61D19oXaxwqbVEOfClDUMlmX6jwrtHzosSFn9lp3WmK1gPdHc6UaZFcBr2OxXdUuj3BvoctyvfTNO0WfvhQqpMj5aUpME7UfitUuac2kb-Y-xUF',
    },
    {
        name: 'Void Jacket',
        category: 'Leather',
        price: '$450',
        alt: 'Leather jacket',
        src: 'https://lh3.googleusercontent.com/aida-public/AB6AXuCvv6xuy4kcqjbRdCsgJ0i-CsdOY8kuJUYyK5JRKg8jBgk2eluHvKObNms3RIOQuw6Z8b-KvNYmvYitQRL6AX4XKY4I4I1yzs85BGOorZ6m4y4-IuSYf48fgKd1VVA7sm5_ikxuVnbFZ7ezzXQm2QFy-SlwtfLS-1klRyoc19sl41oc82AG8nfko4dkLsoedcFdWmL_DZJ3vBPAXP7hH24ALpyz9Pv-LDJJhlcgOgF5TxfX2WsgN5MjLFefm_7jsfBPyYosJULRui8u',
    },
    {
        name: 'Static Cargo',
        category: 'Trousers',
        price: '$180',
        alt: 'Cargo pants',
        src: 'https://lh3.googleusercontent.com/aida-public/AB6AXuCo2ZHJpFkeGcEfSCKuLr3X-M_ZrE9duZEeXz5OjETatSjGwFd247CLdyLjAiiu4gjdmckgCtyNoTuJv9krZDbAvLtIX2msyWDSZwakcB2R82jPuelvKqaPnH6smsvT5C6juPPdl7GlAKYLNYMcY4040V3Af4NcS1-Y5RTN5OY6qDnxupnJ9XMPk8yoGArB0IUc5-jYRLXstn9n9PdFA9AaaDt3ZWGQWlmOFbguGidkzcTDYsFD9iVSl8MR6hpL2FcDVz6e5ii7Pxcf',
    },
    {
        name: 'Glitch Tee',
        category: 'Basics',
        price: '$65',
        alt: 'Graphic T-shirt',
        src: 'https://lh3.googleusercontent.com/aida-public/AB6AXuA--5lRKP20ZInKADmHas41pokqc-p31tT75-euXJiPivIyNBWYW_LjrFjAWzX_dOhPtXtjHHbqeTrpNbXx_tNYwt9YmBGdHkL6M6DJLl2iEgW38ctBW_OHHIdM-JPY5EMJw2uFeiyRWfeNyQebOtSjUKvO56sfoRip7l_AQ4Qsoi2pBfw44LE7V8S48ou0MBqVAkepllFc3Koeidi5KZ8taoCXMIYhYhKZQgeLVu-aqLHZUOeJN97S4JbRqWvUq-KMpisknSaX9Qa0',
    },
];

export default function NewArrivals() {
    return (
        <section className="new-arrivals">
            <div className="new-arrivals__header">
                <h2 className="new-arrivals__title">New Arrivals</h2>
                <a className="new-arrivals__link" href="#">View All</a>
            </div>

            <div className="new-arrivals__grid">
                { products.map((product) => (
                    <div key={product.name} className="new-arrivals__card">
                        <div className="new-arrivals__card-image">
                            <img
                                alt={product.alt}
                                className="new-arrivals__card-img"
                                src={product.src}
                            />
                            <div className="new-arrivals__badge">New</div>
                        </div>

                        <div className="new-arrivals__card-info">
                            <div>
                                <h3 className="new-arrivals__card-name">{product.name}</h3>
                                <p className="new-arrivals__card-category">{product.category}</p>
                            </div>
                            <span className="new-arrivals__card-price">{product.price}</span>
                        </div>
                    </div>
                ))}
            </div>
        </section>
    );
}
